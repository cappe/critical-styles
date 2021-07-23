class GenerateCriticalcssJob < ApplicationJob
  queue_as :default

  def perform(*args)
    # 1. Run system command as pptruser named user: node runner.js
    # 2. Do something with the generated files
    #
    # System command is runuser -m pptruser -c 'node /app/criticalcss/runner.js'
  end
end
