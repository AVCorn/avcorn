#!/bin/bash

echo "Deploying..."

read -p "Enter AWS ID: " awsid
read -p "Enter AWS Region (us-east-2): " awsregion
awsregion=${awsregion:-"us-east-2"}

branch=$(git symbolic-ref -q HEAD)
branch=${branch##refs/heads/}
branch=${branch:-HEAD}
repo=${branch//[\/]/-}
cluster=${repo}
service=${repo}

SCRIPT_DIRECTORY="$(dirname $(realpath "$0"))"
bash "$SCRIPT_DIRECTORY/build.sh"

docker tag avcorn "$awsid.dkr.ecr.$awsregion.amazonaws.com/$branch"

aws ecr get-login-password --region "$awsregion" | docker login --username AWS --password-stdin "$awsid.dkr.ecr.$awsregion.amazonaws.com"

aws ecr create-repository --repository-name "$repo" --region "$awsregion"

docker push "$awsid.dkr.ecr.$awsregion.amazonaws.com/$repo"

aws ecs update-service --cluster "$cluster" --service "$service" --force-new-deployment

echo "Deployment Complete!"