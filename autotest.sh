#!/bin/sh

# Exit on non defined variables and on non zero exit codes
set -eu

echo '# Building the container'

docker build ./ -t nixstatswebhook:latest

NET="${DOCKER_NETWORK:-nixstatswebhook}"

# use failure to switch on create
docker network inspect ${NET} 1>/dev/null 2> /dev/null || docker network create ${NET}

echo '# Preparing test folder'

TMP_DIR="$(mktemp -d 2>/dev/null || mktemp -d -t 'nixstatswebhook')"

printf "<?php \n\
    echo 'PHP: ' . PHP_MAJOR_VERSION . PHP_EOL;\n\
    echo 'Host: ' . \$_SERVER['SERVER_NAME'] . PHP_EOL;\n\
    echo 'Memory-limit: ' . ini_get('memory_limit') . PHP_EOL;\n\
    echo 'Timezone: ' . ini_get('date.timezone') . PHP_EOL;\n\
    echo 'TELEGRAM_BOT_TOKEN: ' . getenv('TELEGRAM_BOT_TOKEN') . PHP_EOL;\n\
    echo 'TELEGRAM_CHATID: ' . getenv('TELEGRAM_CHATID') . PHP_EOL;\n\
    " > "${TMP_DIR}/index.php"

chmod 777 "${TMP_DIR}"
chmod 666 "${TMP_DIR}/index.php"

echo '# Running test containers'

# stop if exists or silently exit
docker stop nixstatswebhook-test 1>/dev/null 2> /dev/null || echo '' >/dev/null

docker run --rm --detach \
    --name nixstatswebhook-test \
    --network ${NET} \
    --volume ${TMP_DIR}:/htdocs \
    --env HTTP_SERVER_NAME="www.example.xyz" \
    --env TZ="Europe/Paris" \
    --env PHP_MEMORY_LIMIT="256M" \
    --env TELEGRAM_BOT_TOKEN="XXXXX" \
    --env TELEGRAM_CHATID="XXXXX" \
    nixstatswebhook:latest 1>/dev/null

echo ''
echo '# Running tests'

docker run --rm --network ${NET} curlimages/curl:latest -s http://nixstatswebhook-test

echo ''
echo '# Cleaning up'
docker stop nixstatswebhook-test 1>/dev/null
docker network rm ${NET} 1>/dev/null

rm "${TMP_DIR}/index.php"
rmdir "${TMP_DIR}"