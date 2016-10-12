#!/usr/bin/env bash
# Create local server
# OSX, brew

source "$(dirname ${BASH_SOURCE[0]})/../../variables.sh"

NGINX_CONF_DIR=/usr/local/etc/nginx/servers/
PHP_VER=7.0
PHP_CONF_DIR=/usr/local/etc/php/$PHP_VER/php-fpm.d/
WEB_ROOT=/
