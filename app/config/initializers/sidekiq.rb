require 'sidekiq'
require 'sidekiq/web'
require 'sidekiq-status'

Sidekiq.configure_client do |config|
  # accepts :expiration (optional)
  Sidekiq::Status.configure_client_middleware config, expiration: 30.minutes
end

Sidekiq.configure_server do |config|
  # accepts :expiration (optional)
  Sidekiq::Status.configure_server_middleware config, expiration: 30.minutes

  # accepts :expiration (optional)
  Sidekiq::Status.configure_client_middleware config, expiration: 30.minutes
end

# Configures Sidekiq-specific session middleware
Sidekiq::Web.use ActionDispatch::Cookies
Sidekiq::Web.use ActionDispatch::Session::CookieStore, key: "_interslice_session"

sidekiq_username = Rails.application.credentials.dig(:sidekiq, :username)
sidekiq_password = Rails.application.credentials.dig(:sidekiq, :password)

Sidekiq::Web.use Rack::Auth::Basic do |username, password|
  ActiveSupport::SecurityUtils.secure_compare(username, sidekiq_username) &
    ActiveSupport::SecurityUtils.secure_compare(password, sidekiq_password)
end unless Rails.env.development?
