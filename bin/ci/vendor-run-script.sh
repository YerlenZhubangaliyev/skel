#!/usr/bin/env bash
# Запуск скриптов из package.json

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

if [ ! -e "$BIN_NPM" ]; then
    echo -e "${COLOR_RED}Npm binary not found${COLOR_STOP}"
    echo -e "You need to install ${COLOR_BLUE}npm${COLOR_STOP}"
    exit
fi

cd "${DIR_APP_STATIC}"

exec ${BIN_NPM} run-script install

cd "${DIR_CURR}"

echo "All done\n"
