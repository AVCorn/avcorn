#!/bin/bash

echo "Building AVCorn Container..."
docker build -t avcorn .  -f container/Dockerfile 2>&1 | tee ./code/logs/docker-build


echo "Running AVCorn Container..."
docker run -d -p 80:80 avcorn:latest 2>&1 | tee ./code/logs/docker-run