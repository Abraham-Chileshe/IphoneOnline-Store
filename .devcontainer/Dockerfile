FROM mcr.microsoft.com/devcontainers/base:ubuntu-24.04

# Install PHP, Composer, and Node.js for Laravel
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -y install --no-install-recommends \
        php8.3 \
        php8.3-cli \
        php8.3-common \
        php8.3-curl \
        php8.3-mbstring \
        php8.3-xml \
        php8.3-zip \
        php8.3-sqlite3 \
        php8.3-pdo \
        unzip \
        curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*
