#!/bin/bash

echo "Setting Up AVCorn..."
docker build -t avcorn . -f container/Dockerfile


echo "Running AVCorn..."
docker run avcorn