class ApplicationController < ActionController::Base
  include ActiveStorage::SetCurrent
  #
  # TODO: Replace hard-coded value with something dynamic. Maybe from docker-compose.yaml?
  # before_action do
  #   ActiveStorage::Current.host = 'http://localhost:3000'
  # end
end
