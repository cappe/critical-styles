# MinimalCSS needs to be run by non-root user. Non-root user is set up
# in Dockerfile, and it has writing access only to its home directory.
# Hence, we have a dedicated tmp storage.
tmp_storage = ENV.fetch("TMP_STORAGE")
FileUtils.mkdir_p(tmp_storage) unless File.directory?(tmp_storage)
