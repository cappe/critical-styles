require 'sidekiq/web'

Rails.application.routes.draw do
  devise_for :users # This needs to come first so Devise can load its magic

  namespace :api, constraints: lambda { |req| req.format == :json } do
    scope module: :v1, path: 'v1' do
      resource :user, only: :show
      resources :users, only: [] do
        resources :domains, only: [:index]
      end
    end
  end

  mount Sidekiq::Web => '/sidekiq'
end
