class Api::V1::UsersController < Api::V1::ApiController
  def show
    render json: current_user.to_json
  end
end
