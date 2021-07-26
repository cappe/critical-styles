class UserSerializer < BaseSerializer
  attributes :id,
             :api_token,
             :email

  has_many :domains, lazy_load_data: false, links: {
    related: -> (object) {
      "/api/v1/users/#{object.id}/domains"
    }
  }
end
