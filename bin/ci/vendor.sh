#!/usr/bin/env bash
# Устанавливаем зависимости Composer/Nodejs

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

echo "Downloading composer\n"
curl -sS https://getcomposer.org/installer | php

echo "Installing dependencies\n"
php composer.phar install --no-dev --optimize-autoloader

if [ ! -e "$BIN_NPM_CACHE" ]; then
    echo -e "${COLOR_RED}Npm-cache binary not found${COLOR_STOP}"
    echo -e "You need to install ${COLOR_BLUE}npm install npm-cache -g${COLOR_STOP}"
    exit
fi

cd "${DIR_STATIC}"

echo "Starting npm install\n"
$BIN_NPM_CACHE install npm

cd "${DIR_CURR}"

echo "All done\n"
