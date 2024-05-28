#!/bin/bash
set -e

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)

cd "${SCRIPT_DIR}"

source "${SCRIPT_DIR}/.env"

docker exec -u www -it "$(docker ps -f name="${APP_NAME}"-php -q)" composer $@
