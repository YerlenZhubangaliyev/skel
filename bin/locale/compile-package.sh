#!/usr/bin/env bash
# Компиляция ResourceBundle Package

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

if [ -e "${DIR_APP_LOCALE_RES}" ]; then
    cd ${DIR_APP_LOCALE_RES}

    echo -n "" > ${FILE_PACKAGE}

    for file in ${DIR_APP_LOCALE_RES}/*.res
    do
        if [[ -f ${file} ]]; then
            echo ${file##*/} >> ${FILE_PACKAGE}
        fi
    done

    exec ${BIN_PKGDATA} -p ${APP}_${MOD} -d ${DIR_LOCALE} -T ${DIR_TMP} ${FILE_PACKAGE}
    cd ${DIR_CURR}
fi
