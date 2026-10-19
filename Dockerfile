# Development tools for the Vue frontend and Laravel API.
FROM node:24-bookworm-slim AS node_tools
FROM composer:2 AS composer_tools

FROM php:8.4-cli-bookworm AS development

RUN apt-get update \
    && apt-get install -y --no-install-recommends git libatomic1 libstdc++6 unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=node_tools /usr/local/bin/node /usr/local/bin/node
COPY --from=node_tools /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm
COPY --from=composer_tools /usr/bin/composer /usr/local/bin/composer

RUN ln -s ../lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s ../lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && useradd --create-home --uid 1000 --shell /bin/bash app \
    && mkdir -p /workspace \
    && chown app:app /workspace

WORKDIR /workspace
COPY --chown=app:app . .

USER 1000:1000
CMD ["bash"]
