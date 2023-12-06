#!/bin/bash

echo "Shelling in to AVCorn Container..."
docker exec -it `docker ps -q --filter ancestor=avcorn-web` bash  2>&1 | tee ./code/logs/docker-exec

echo "Shell exited!"