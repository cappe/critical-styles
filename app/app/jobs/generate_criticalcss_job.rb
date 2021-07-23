class GenerateCriticalcssJob < ApplicationJob
  queue_as :default

  def perform(webpage_id:)
    webpage = Webpage.find(webpage_id)
    tmp_bundled_css_filename = "#{SecureRandom.urlsafe_base64(64)}.css"
    tmp_critical_css_filename = "#{SecureRandom.urlsafe_base64(64)}.css"
    tmp_dir = Rails.root.join('tmp', 'storage').to_s

    command = [
      'runuser -m pptruser -c',
      '"',
      'node /app/criticalcss/runner.js',
      "--page_url=#{webpage.url}",
      "--tmp_bundled_css_filename=#{tmp_bundled_css_filename}",
      "--tmp_critical_css_filename=#{tmp_critical_css_filename}",
      "--tmp_dir=#{tmp_dir}",
      '"',
    ]

    # Code will wait for this to finish so the CSSs should be there.
    # It's not guaranteed so we may need to hande that case at some point.
    system(command.join(' '))

    # .attach will purge previous file if it exists
    tmp_bundled_css = "#{tmp_dir}/#{tmp_bundled_css_filename}"
    webpage.bundled_css.attach(
      io: File.open(tmp_bundled_css),
      filename: tmp_bundled_css_filename
    )
    File.delete(tmp_bundled_css)

    # .attach will purge previous file if it exists
    tmp_critical_css = "#{tmp_dir}/#{tmp_critical_css_filename}"
    webpage.critical_css.attach(
      io: File.open(tmp_critical_css),
      filename: tmp_critical_css_filename
    )
    File.delete(tmp_critical_css)
  end
end
