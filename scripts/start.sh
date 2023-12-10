#!/bin/bash

SCRIPT_DIRECTORY="$(dirname $(realpath "$0"))"
. $SCRIPT_DIRECTORY/build.sh

echo "Starting Container..."
docker run -d -p 80:80 avcorn:latest 2>&1 | tee ./code/backend/logs/docker-run

echo -e "Container Running! Visit: \e]8;;http://localhost:80\e\\http://localhost:80\e]8;;\e\\";