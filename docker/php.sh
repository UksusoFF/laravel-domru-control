#!/bin/bash
set -e

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)

cd "${SCRIPT_DIR}"

source "${SCRIPT_DIR}/.env"

docker exec -u www -e PHP_IDE_CONFIG="serverName=${APP_NAME}" -it "$(docker ps -f name="${APP_NAME}"-php -q)" php $@
