#!/bin/bash
set -e

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)

cd "${SCRIPT_DIR}"

source "${SCRIPT_DIR}/.env"

docker compose --file docker-compose.yml --project-name "${APP_NAME}" build --no-cache
