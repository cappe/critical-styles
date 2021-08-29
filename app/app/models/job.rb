class Job < ApplicationRecord
  belongs_to :domain
  belongs_to :user
  belongs_to :webpage

  # [ :queued, :working, :retrying, :complete, :stopped, :failed, :interrupted ]
  STATUSES = Sidekiq::Status::STATUS.map(&:to_s)

  enum status: STATUSES

  validates :status,
            presence: true,
            inclusion: { in: STATUSES }

  # Sidekiq job statuses takes precedence. However, they are
  # only temporary so we track the status using the .status
  # attribute.
  def job_status
    Sidekiq::Status::status(self.jid) || self.status
  end
end
