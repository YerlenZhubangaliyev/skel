#!/usr/bin/env bash

# Deploy через CI в соответствующее окружение

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"

if [ ! -e ${BIN_RSYNC} ] ; then
    echo -e "${COLOR_RED}rsync${COLOR_STOP} executable not found"
    exit
fi

echo -e "Start rsync to ${COLOR_GREEN}${HOST_REMOTE}${COLOR_STOP}"

cd ${DIR_ROOT}
exec ${BIN_RSYNC} -azcC --progress --delete-before --include-from="${FILE_INCLUDE_LIST}" --exclude-from="${FILE_EXCLUDE_LIST}" "." "${USER_REMOTE}@${HOST_REMOTE}:${PATH_REMOTE}"
cd ${DIR_CURR}
