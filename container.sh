#!/bin/bash

# Path to Artifactory image and version string, given by Jenkins
DOCKERSEARCHIMAGE="$1"

# Variables common between all environments
DOCKERSEARCH="dhpid-search" #Search site
FRESHINSTALL=false
SECRETS_FILE="${HOME}/secrets/search_secrets.sh"

# Check if an existing container exists to determine if this is a fresh install or an update
if [ ! "$(docker ps -q -f name=${DOCKERSEARCH})" ]; then
  FRESHINSTALL=true
fi

docker network create appnet || true

# Stop & remove existing
docker stop ${DOCKERSEARCH} || true
docker rm ${DOCKERSEARCH} || true

# Source the secrets file to obtain the correct database hostname and IP
. ${SECRETS_FILE}
# Sanity checks
if [ -z "${DB_HOST}" ] || [ -z "${DB_HOST_IP}" ]; then
    echo "$0 ERROR: Please ensure DB_HOST and DB_HOST_IP are set in ${SECRETS_FILE}"
    exit 1
fi

# Docker PHP containers
# Use "--add-host" to ensure that the database service is reachable by
# the hostname which matches its TLS certificate.

# Search site
docker create --name ${DOCKERSEARCH} \
    -p :443 \
    --env-file ${SECRETS_FILE} \
    --add-host ${DB_HOST}:${DB_HOST_IP} \
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
