#!/usr/bin/env bash
# Переменные

COLOR_RED="\e[41m"
COLOR_BLUE="\e[44m"
COLOR_GREEN="\e[42m"
COLOR_STOP="\e[0m"

ENV=$1
APP=$2
MOD=$3
CMD=$4

USER=www-data

BIN_NODE=node
BIN_NPM=/usr/bin/npm
BIN_GULP=/usr/bin/gulp
BIN_NPM_CACHE=/usr/bin/npm-cache
BIN_RSYNC=/usr/bin/rsync
BIN_GENRB=genrb
BIN_PKGDATA=pkgdata

DIR_ROOT="$( cd "$( dirname $BASH_SOURCE[0] )" && cd ../.. && pwd )"
DIR_CURR=`pwd`
DIR_TMP="${DIR_ROOT}/tmp"
DIR_DATA="${DIR_ROOT}/data"
DIR_STATIC="${DIR_ROOT}/static"
DIR_STATIC_BUILD="${DIR_ROOT}/_skel/static"
DIR_LOCALE="${DIR_DATA}/locale"
DIR_APP_STATIC="${DIR_STATIC}/${APP}"
DIR_APP_STATIC_LC="${DIR_STATIC}/"
DIR_APP_STATIC_LC+=`echo ${DIR_APP_STATIC_LC} | tr '[:upper:]' '[:lower:]'`
DIR_APP_SRC_DIR="${DIR_APP_STATIC}/src"
DIR_APP_SRC_DIR_LC="${DIR_APP_STATIC_LC}/src"
DIR_APP_LOCALE="${DIR_LOCALE}/"
DIR_APP_LOCALE+=`echo "${APP}/${MOD}" | tr '[:upper:]' '[:lower:]'`
DIR_APP_LOCALE_RES="${DIR_APP_LOCALE}/res"
DIR_APP_LOCALE_SRC="${DIR_APP_LOCALE}/src/txt"

FILE_EXCLUDE_LIST="${DIR_DATA}/deploy/exclude.txt"
FILE_INCLUDE_LIST="${DIR_DATA}/deploy/includes.txt"
FILE_PACKAGE="package.txt"

APPS=(frontend backend)

USER_REMOTE=""

if [ ! -n "${ENV}" ]; then
    echo -e "Please provide an ${COLOR_RED}environment (First argument)${COLOR_STOP}"
    exit
fi

source "$(dirname ${BASH_SOURCE[0]})/variables-${ENV}.sh"

if [ -e $(dirname ${BASH_SOURCE[0]})/../../bin/variables-${ENV}.sh ]; then
    source $(dirname ${BASH_SOURCE[0]})/../../bin/variables-${ENV}.sh
fi
