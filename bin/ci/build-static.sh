#!/usr/bin/env bash
# Запуск gulp с параметрами по умолчанию

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

if [ ! -e "$BIN_GULP" ]; then
    echo -e "${COLOR_RED}Gulp binary not found${COLOR_STOP}"
    echo -e "You need to install ${COLOR_BLUE}npm install gulp -g${COLOR_STOP}"
    exit
fi

cd "${DIR_STATIC_BUILD}"

$BIN_NPM install

cp -R node_modules ../../static/

echo "Start to build static"
$BIN_GULP --app="${APP}" --env="${ENV}" --mod="${MOD}"

cd "${DIR_CURR}"
