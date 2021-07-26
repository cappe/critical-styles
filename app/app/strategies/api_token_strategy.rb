class ApiTokenStrategy < Warden::Strategies::Base
  include ActionController::HttpAuthentication::Token::ControllerMethods

  def valid?
    api_token.present?
  end

  def authenticate!
    user = User.find_by(api_token: api_token)

    if user
      success!(user)
    else
      fail!('Invalid email or password')
    end
  end

  def store?
    false
  end

  private

    def api_token
      authenticate_with_http_token do |access_token, options|
        access_token
      end
    end
end
