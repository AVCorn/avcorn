#!/bin/bash

echo "Deploying..."

read -p "Enter AWS ID: " awsid
read -p "Enter AWS Region (us-east-2): " awsregion
awsregion=${awsregion:-"us-east-2"}

branch=$(git symbolic-ref -q HEAD)
branch=${branch##refs/heads/}
branch=${branch:-HEAD}

SCRIPT_DIRECTORY="$(dirname $(realpath "$0"))"
. $SCRIPT_DIRECTORY/build.sh

docker tag avcorn "$awsid.dkr.ecr.$awsregion.amazonaws.com/$branch"

aws ecr get-login-password --region $awsregion | docker login --username AWS --password-stdin "$awsid.dkr.ecr.$awsregion.amazonaws.com"

docker push "$awsid.dkr.ecr.$awsregion.amazonaws.com/$branch"

echo "Deployment Complete!"