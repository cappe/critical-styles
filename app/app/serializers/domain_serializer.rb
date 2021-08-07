class DomainSerializer < BaseSerializer
  attributes :id,
             :url

  has_many :webpages, lazy_load_data: true, links: {
    index: -> (object, params) {
      params[:context].api_domain_webpages_path(object)
    },
    create: -> (object, params) {
      params[:context].api_domain_webpages_path(object)
    }
  }
end
