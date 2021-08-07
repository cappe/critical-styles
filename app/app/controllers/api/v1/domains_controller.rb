class Api::V1::DomainsController < Api::V1::ApiController
  def index
    render json: DomainSerializer.new(
      current_user.domains,
      params: { context: self }
    )
  end
end
