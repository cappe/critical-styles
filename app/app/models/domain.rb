class Domain < ApplicationRecord
  belongs_to :user
  has_many :jobs, dependent: :destroy
  has_many :webpages,
           dependent: :destroy,
           inverse_of: :domain
end
