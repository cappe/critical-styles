require 'sidekiq/web'

Rails.application.routes.draw do
  namespace :api, constraints: lambda { |req| req.format == :json } do
    scope module: :v1, path: 'v1' do
      resource :user, only: :show
    end
  end

  # To be used later
  # devise_for :users

  mount Sidekiq::Web => '/sidekiq'
end
