#!/bin/bash

echo "Building AVCorn Container..."
docker build -t avcorn .  -f container/Dockerfile 2>&1 | tee ./code/app/logs/docker-build


echo "Running AVCorn Container..."
docker run -d -p 80:80 avcorn:latest 2>&1 | tee ./code/app/logs/docker-run

echo -e "Complete! Visit: \e]8;;http://localhost:80\e\\http://localhost:80\e]8;;\e\\";