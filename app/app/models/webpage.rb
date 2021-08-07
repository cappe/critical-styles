class Webpage < ApplicationRecord
  belongs_to :domain

  has_one_attached :bundled_css # All stylesheets bundled together
  has_one_attached :critical_css # Critical CSS

  validates :path,
            presence: true,
            length: { maximum: 2048 }

  def url
    self.domain.url + self.path
  end
end
