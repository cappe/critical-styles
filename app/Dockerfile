###############################################
##### BASE BUILD
FROM ruby:2.7.2
ARG BUNDLE_WITHOUT

# Ensure latest packages for Yarn
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash -
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

# Allow apt to work with https-based sources
RUN apt-get update -yqq && apt-get install -yqq --no-install-recommends \
    apt-transport-https \
    nodejs \
    postgresql-client \
    yarn \
    wget \
    gnupg \
        && wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
        && sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list' \
        && apt-get update \
        && apt-get install -y google-chrome-stable fonts-ipafont-gothic fonts-wqy-zenhei fonts-thai-tlwg fonts-kacst fonts-freefont-ttf libxss1 \
          --no-install-recommends \
        && rm -rf /var/lib/apt/lists/*

# Tell Puppeteer to skip installing Chrome. We'll be using the installed package.
# You'll need to launch puppeteer with: browser.launch({ executablePath: 'google-chrome-stable' })
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    PUPPETEER_EXECUTABLE_PATH=/usr/bin/google-chrome-stable \
    NODE_PATH="/usr/local/share/.config/yarn/global/node_modules"

ENV TMP_STORAGE=/home/builder

# Install puppeteer so it's available in the container.
#RUN yarn global add puppeteer penthouse \
    # Add user so we don't need --no-sandbox.
    # same layer as npm install to keep re-chowned files from using up several hundred MBs more space
RUN groupadd -r builder \
        && useradd -r -g builder -G audio,video builder \
        && mkdir -p $TMP_STORAGE \
        && chown -R builder:builder $TMP_STORAGE

# Add the Rails app and set workdir
WORKDIR /app
ADD . ./

# install all dependencies
RUN bundle install -j5 --retry 3
RUN yarn install --check-files
