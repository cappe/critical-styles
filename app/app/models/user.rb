class User < ApplicationRecord
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable, :trackable and :omniauthable
  devise :database_authenticatable,
         :confirmable,
         :recoverable,
         :registerable,
         :rememberable,
         :trackable,
         :validatable

  has_many :domains, dependent: :destroy
  has_many :webpages, through: :domains
  has_many :jobs, dependent: :destroy
end
