#!/bin/bash

echo "Building Container..."
docker build -t avcorn . -f container/Dockerfile 2>&1 | tee ./code/backend/logs/docker-build

echo "Builing complete!"