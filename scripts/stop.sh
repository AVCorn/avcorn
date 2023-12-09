#!/bin/bash

echo "Removing AVCorn Container..."
docker rm $(docker stop $(docker ps -a -q --filter ancestor=avcorn-web --format="{{.ID}}")) 2>&1 | tee ./code/app/logs/docker-rm


echo "Complete!";