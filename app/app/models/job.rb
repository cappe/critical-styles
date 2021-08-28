class Job < ApplicationRecord
  belongs_to :domain
  belongs_to :user
  belongs_to :webpage

  def status
    Sidekiq::Status::status(self.jid) || :unknown
  end
end
