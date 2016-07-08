#!/usr/bin/env bash
# Компиляция ResourceBundle Resources (.res)

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

if [ -e "${DIR_APP_LOCALE_SRC}" ]; then
    cd ${DIR_APP_LOCALE_SRC}
    exec ${BIN_GENRB} -x -q -d ${DIR_APP_LOCALE_RES} * >/dev/null
    cd ${DIR_CURR}
fi
