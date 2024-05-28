#!/bin/bash
set -e

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)

cd "${SCRIPT_DIR}"

source "${SCRIPT_DIR}/.env"

winpty docker exec -u root -it "$(docker ps -f name="${APP_NAME}"-php -q)" bash
