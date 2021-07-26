class Api::V1::UsersController < Api::V1::ApiController
  def show
    render json: UserSerializer.new(current_user)
  end
end
