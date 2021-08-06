class DomainSerializer < BaseSerializer
  attributes :id,
             :url

  has_many :webpages, lazy_load_data: true, links: {
    related: -> (object) {
      "/api/v1/domains/#{object.id}/webpages"
    }
  }
end
