#!/usr/bin/env bash

source "$(dirname ${BASH_SOURCE[0]})/../variables.sh"
source "$(dirname ${BASH_SOURCE[0]})/remote-commands.sh"

for command in ${REMOTE_COMMANDS}
do
  ssh ${USER_REMOTE}@${HOST_REMOTE} ${command}
done
