class Webpage < ApplicationRecord
  has_many :jobs, dependent: :destroy
  belongs_to :domain, inverse_of: :webpages

  has_one :latest_job,
          -> { order(created_at: :desc) },
          class_name: 'Job',
          inverse_of: :webpage

  scope :with_latest_job, -> { includes(:latest_job) }

  delegate :job_status,
           to: :latest_job

  has_one_attached :bundled_css # All stylesheets bundled together
  has_one_attached :critical_css # Critical CSS

  validates :path,
            presence: true,
            length: { maximum: 2048 },
            uniqueness: true

  def url
    self.domain.url + self.path
  end

  def critical_css_url
    Rails.application.routes.url_helpers.rails_blob_url(
      critical_css&.blob,
      Rails.application.config.action_mailer.default_url_options
    )
  rescue
    nil
  end

  def critical_css_filename
    critical_css.filename
  end

  def generate_critical_css!
    unless block_given?
      raise 'gimme a block to setup the data!'
    end

    job = Job.new
    job.status = :queued
    job.webpage = self
    job.domain = self.domain
    job.jid = GenerateCriticalcssJob
                .perform_later(webpage_id: self.id)
                &.provider_job_id

    yield job # Allows the caller to set the user who initiated the job

    job.save!
  end
  alias_method :regenerate_critical_css!, :generate_critical_css!
end
