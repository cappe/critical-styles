class Domain < ApplicationRecord
  belongs_to :user
  has_many :webpages, dependent: :destroy
end
