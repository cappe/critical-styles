class ApplicationController < ActionController::Base
  before_action do
    ActiveStorage::Current.host = ENV.fetch("HOST_URL")
  end
end
