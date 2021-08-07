class UserSerializer < BaseSerializer
  attributes :id,
             :api_token,
             :email

  has_many :domains, lazy_load_data: true, links: {
    index: -> (_, params) {
      params[:context].api_domains_path
    }
  }
end
