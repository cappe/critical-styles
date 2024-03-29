Rails.application.routes.draw do
  devise_for :users # This needs to come first so Devise can load its magic

  namespace :api, constraints: lambda { |req| req.format == :json } do
    scope module: :v1, path: 'v1' do
      resource :user, only: :show
      resources :domains, only: [:index], shallow: true do
        resources :webpages, only: [:show, :create, :update]
      end
    end
  end

  mount Sidekiq::Web => '/sidekiq'
end
