class ApplicationController < ActionController::Base
  before_action do
    # ActiveStorage::Current.host = ENV.fetch("HOST_URL") || 'web:3000'
    # ActiveStorage::Current.host = '192.168.10.41:8000'
    # ActiveStorage::Current.host = 'web:3000'
  end
end
