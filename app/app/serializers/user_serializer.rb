class UserSerializer < BaseSerializer
  attributes :id,
             :api_token,
             :email

  has_many :domains, lazy_load_data: true, links: {
    related: -> {
      "/api/v1/domains"
    }
  }
end
