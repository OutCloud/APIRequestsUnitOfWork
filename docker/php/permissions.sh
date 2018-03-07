#!/usr/bin/env bash

EXISTS=$(cat /etc/group | grep $TARGET_GID | wc -l)
USER_EXISTS=$(cat /etc/passwd | grep :x:$TARGET_GID | wc -l)

  # Create new group using target GID and add nobody user
  if [ ${EXISTS} == "0" ]; then
    groupadd -g ${TARGET_GID} tempgroup
    usermod -a -G tempgroup nobody
    usermod -a -G tempgroup www-data
    GRP=tempgroup
  else
    # GID exists, find group name and add
    GRP=$(getent group $TARGET_GID | cut -d: -f1)
    usermod -a -G ${GRP} nobody
    usermod -a -G ${GRP} www-data
  fi

  if [ ${USER_EXISTS} == "0" ]; then
    useradd -M -N -u ${TARGET_GID} tempuser # create tempuser
    usermod -L tempuser # do not allow tempuser to login
  else
    USR=$(getent passwd $TARGET_GID | cut -d: -f1)
    usermod -a -G ${GRP} ${USR}
  fi

