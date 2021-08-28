class Webpage < ApplicationRecord
  has_many :jobs, dependent: :destroy
  belongs_to :domain

  has_one :latest_job,
          -> { order(created_at: :desc) },
          class_name: 'Job',
          inverse_of: :webpage

  scope :with_latest_job, -> { includes(:latest_job) }

  delegate :status,
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
    critical_css.url
  end
end
