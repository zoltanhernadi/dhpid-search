#!/bin/bash

# Path to Artifactory image and version string, given by Jenkins
DOCKERSEARCHIMAGE="$1"

# Variables common between all environments
DOCKERSEARCH="dhpid-search" #Search site
FRESHINSTALL=false

# Check if an existing container exists to determine if this is a fresh install or an update
if [ ! "$(docker ps -q -f name=${DOCKERSEARCH})" ]; then
  FRESHINSTALL=true
fi

docker network create appnet || true

# Stop & remove existing
docker stop ${DOCKERSEARCH} || true
docker rm ${DOCKERSEARCH} || true

# Docker PHP containers
# Use "--add-host" to ensure that the database service is reachable by
# the hostname which matches its TLS certificate.

# Search site
docker create --name ${DOCKERSEARCH} \
    -p 8000:80 \
    -e WEBROOT=/var/www/dhpid-search/public \
    --env-file ${HOME}/secrets/search_secrets.sh \
    --add-host cr2.canadacentral1-a.control.database.windows.net:10.180.29.6 \
    --restart always \
    ${DOCKERSEARCHIMAGE} \
    /install.sh

docker network connect appnet ${DOCKERSEARCH}

# Function to get the internal IP for the Docker container once started - used in local environments only
get_search_ip ()
{
  docker inspect -f '{{ .NetworkSettings.Networks.appnet.IPAddress }}' ${DOCKERSEARCH}
}

# IPAddress for the PHP containers to be used when creating the users in the database
SEARCHIP=`get_search_ip`

# Start environment
docker start ${DOCKERSEARCH}
