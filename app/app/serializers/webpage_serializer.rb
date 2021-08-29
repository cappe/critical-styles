class WebpageSerializer < BaseSerializer
  attributes :id,
             :critical_css_filename,
             :critical_css_url,
             :path,
             :job_status
end
