#!/bin/bash

echo "Building Container..."
docker build -t avcorn . -f container/Dockerfile 2>&1 | tee ./code/app/logs/docker-build

echo "Builing complete!"