class Api::V1::WebpagesController < Api::V1::ApiController
  def create
    webpage_paths = params[:webpage_paths]&.values || []
    current_webpages = current_domain.webpages

    webpage_paths.each do |webpage_path|
      next if current_webpages.any? { |webpage| webpage.path === webpage_path }

      webpage = current_domain.webpages.build
      webpage.path = webpage_path

      if webpage.save
        active_job = GenerateCriticalcssJob.perform_later(webpage_id: webpage.id)

        job = Job.new
        job.jid = active_job&.provider_job_id
        job.domain = current_domain
        job.user = current_user
        job.webpage = webpage
        job.save!
      else
        # TODO: How to handle this case?
        # raise ActiveRecord::Rollback, "Creating a new webpage failed, transaction rolling back..."
      end
    end

    webpages = current_user
                 .webpages
                 .with_attached_critical_css
                 .with_latest_job
                 .where(domain_id: params[:domain_id])

    render json: WebpageSerializer.new(webpages)
  end

  private

    def current_domain
      @current_domain ||= current_user
                            .domains
                            .find(params[:domain_id])
    end
end
