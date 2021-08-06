class Api::V1::WebpagesController < ApplicationController
  def index
    webpages = current_user
                 .webpages
                 .where(domain_id: params[:domain_id])

    render json: WebpageSerializer.new(webpages)
  end
end
