class Api::V1::WebpagesController < Api::V1::ApiController
  def index
    webpages = current_user
                 .webpages
                 .where(domain_id: params[:domain_id])

    render json: WebpageSerializer.new(webpages)
  end

  def create
    paths = params[:paths].values
    webpages = []

    Webpage.transaction do
      paths.each do |path|
        webpage = current_domain.webpages.build
        webpage.path = path

        if webpage.save
          webpages << webpage
        else
          raise ActiveRecord::Rollback, "Creating a new webpage saved, transaction rolling back..."
        end
      end
    end

    render json: WebpageSerializer.new(webpages)
  end

  private

    def current_domain
      @current_domain ||= current_user
                            .domains
                            .find(params[:domain_id])
    end
end
