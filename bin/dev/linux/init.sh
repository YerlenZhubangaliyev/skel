#!/usr/bin/env bash
# Create local server
# Linux, apt-get

source "$(dirname ${BASH_SOURCE[0]})/../../variables.sh"

NGINX_CONF_DIR=/etc/nginx/conf.d/
PHP_VER=7.0
PHP_CONF_DIR=/etc/php/$PHP_VER/fpm/pools.d/
WEB_ROOT=/
