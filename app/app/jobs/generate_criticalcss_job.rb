class GenerateCriticalcssJob < ApplicationJob
  queue_as :default

  include Sidekiq::Status::Worker # enables job status tracking

  # Uses https://github.com/peterbe/minimalcss

  def perform(webpage_id:)
    webpage = Webpage.find(webpage_id)
    tmp_critical_css_filename = "#{SecureRandom.urlsafe_base64(64)}.css"
    tmp_dir = ENV.fetch("TMP_STORAGE")
    tmp_critical_css = "#{tmp_dir}/#{tmp_critical_css_filename}"

    command = [
      'runuser -m builder -c',
      '"',
      "./node_modules/minimalcss/bin/minimalcss.js #{webpage.url} > #{tmp_critical_css}",
      '"',
    ]

    pid = Process.spawn(command.join(' '))
    puts "Started a process with pid: #{pid}..."

    # Found out that minimalcss.js hangs sometimes. Before figuring out
    # what's up, let's have a timeout that'd kill hanging processes.
    begin
      Timeout.timeout(30) do
        puts "Waiting for the process (pid: #{pid}) to end..."
        Process.wait(pid)
        puts "Process (pid: #{pid}) finished in time..."
      end
    rescue Timeout::Error
      puts "Process (pid: #{pid}) not finished in time, killing it..."
      Process.kill('TERM', pid)
    end

    # true => success (exit code 0)
    # false => non-zero exit code
    # nil => fail
    success = $?&.success?

    if success == true
      webpage.critical_css.attach(
        io: File.open(tmp_critical_css),
        filename: tmp_critical_css_filename
      )
      File.delete(tmp_critical_css)

      Job.find_by_jid(self.provider_job_id)&.complete!
    else
      puts "Could not generate critical CSS for #{webpage_id}..."
      puts "Process (pid: #{}) errors: #{$?.inspect}"

      Job.find_by_jid(self.provider_job_id)&.failed!
    end
  end
end
