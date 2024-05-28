#!/bin/bash
set -e

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)

cd "${SCRIPT_DIR}"

source "${SCRIPT_DIR}/.env"

TARGET_DIR="${SCRIPT_DIR}/data/private"

if [ ! -f "${TARGET_DIR}/ssl.key" ]; then
    echo "Not found certificate. Start install..."

    mkcert -install
    mkcert -key-file="${TARGET_DIR}/ssl.key" -cert-file="${TARGET_DIR}/ssl.crt" "${APP_DOMAIN}"

    cat "$(mkcert -CAROOT)/rootCA.pem" > "${TARGET_DIR}/mkcertCA.crt"
fi

if grep -q "${APP_DOMAIN}" /etc/hosts; then
    echo "Domain ${APP_DOMAIN} already exist in /etc/hosts"
else
    echo "Adding ${APP_DOMAIN} domain to /etc/hosts..."
    #echo "127.0.0.1 ${APP_DOMAIN}" | sudo tee -a /etc/hosts
fi
