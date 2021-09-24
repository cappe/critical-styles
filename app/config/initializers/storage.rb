# Temporary critical CSS files are saved here
tmp_storage = Rails.root.join('tmp', 'storage').to_s
FileUtils.mkdir_p(tmp_storage) unless File.directory?(tmp_storage)
