#!/bin/bash
echo "==========| REGION = ${REPO_REGION}"
echo "==========| URL:TAG = ${DOCKER_REPO_URL}:${TAG}"
echo "==========| Login AWS_ECR using Docker:"
echo ""
aws ecr get-login-password --region $REPO_REGION | docker login --username AWS --password-stdin $ECR_REPO_URL

echo "==========| Build Docker Container:"
echo ""
docker build -t $APP_NAME-$ENV_NAME:$TAG .

echo "==========| Tag Docker Container:"
echo ""
docker tag $APP_NAME-$ENV_NAME:$TAG $ECR_REPO_URL/$APP_NAME-$ENV_NAME:$TAG

echo "==========| Push to AWS_ECR:"
echo ""
docker push $ECR_REPO_URL/$APP_NAME-$ENV_NAME:$TAG