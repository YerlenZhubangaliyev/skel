#!/usr/bin/env bash

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

cd ${DIR_APP_LOCALE_RES}
mv -f *.xlf ${DIR_XLIFF}
cd ${DIR_CURR}