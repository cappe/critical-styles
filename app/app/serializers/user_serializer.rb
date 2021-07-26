class UserSerializer < BaseSerializer
  attributes :api_token,
             :email

  has_many :domains, lazy_load_data: false, links: {
    related: -> (object) {
      "/api/v1/#{object.id}/domains"
    }
  }
end
