class User < ApplicationRecord
  has_many :domains, dependent: :destroy
end
