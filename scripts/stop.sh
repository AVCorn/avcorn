#!/bin/bash

echo "Removing AVCorn Container..."
docker rm $(docker stop $(docker ps -a -q --filter ancestor=avcorn --format="{{.ID}}")) 2>&1 | tee ./code/logs/docker-rm