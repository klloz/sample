#!/bin/bash -e
COMPOSE_PROJECT_NAME=sample
DOMAIN=sample.kl
DOCKER_COMPOSE_DIR=./
HOST_FILE=/etc/hosts
cd $DOCKER_COMPOSE_DIR
WEB_IP=$( docker inspect  --format='{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' ${COMPOSE_PROJECT_NAME}-nginx )
printf "\n# web_container_IP - ${COMPOSE_PROJECT_NAME}\n" | sudo tee -a  ${HOST_FILE} > /dev/null
printf "${WEB_IP}\t${DOMAIN}\n" | sudo tee -a ${HOST_FILE} > /dev/null
