#!/bin/bash

if [ -z "${TEST_PHP_VERSION}+x" ]; then
    TEST_PHP_VERSION=php72
fi

function runLint() {
    docker run \
        -u ${HOST_UID} \
        -v /bamboo-data/${BAMBOO_COMPOSE_PROJECT_NAME}/passwd:/etc/passwd \
        -v ${BAMBOO_COMPOSE_PROJECT_NAME}_bamboo-data:/srv/bamboo/xml-data/build-dir/ \
        -e HOME=${HOME} \
        --name ${BAMBOO_COMPOSE_PROJECT_NAME}sib_adhoc \
        --rm \
        typo3gmbh/${TEST_PHP_VERSION}:latest \
        bin/bash -c "cd ${PWD}; find . -name \*.php -print0 | xargs -0 -n1 -P2 php -n -c /etc/php/cli-no-xdebug/php.ini -d display_errors=stderr -l >/dev/null"
}

function runComposer() {
    docker run \
        -u ${HOST_UID} \
        -v /bamboo-data/${BAMBOO_COMPOSE_PROJECT_NAME}/passwd:/etc/passwd \
        -v ${BAMBOO_COMPOSE_PROJECT_NAME}_bamboo-data:/srv/bamboo/xml-data/build-dir/ \
        -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} \
        -e HOME=${HOME} \
        --name ${BAMBOO_COMPOSE_PROJECT_NAME}sib_adhoc \
        --rm \
        typo3gmbh/${TEST_PHP_VERSION}:latest \
        bin/bash -c "cd ${PWD}; composer $*"
}

function runPhpCsFixer() {
    docker run \
        -u ${HOST_UID} \
        -v /bamboo-data/${BAMBOO_COMPOSE_PROJECT_NAME}/passwd:/etc/passwd \
        -v ${BAMBOO_COMPOSE_PROJECT_NAME}_bamboo-data:/srv/bamboo/xml-data/build-dir/ \
        -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} \
        -e HOME=${HOME} \
        --name ${BAMBOO_COMPOSE_PROJECT_NAME}sib_adhoc \
        --rm \
        typo3gmbh/${TEST_PHP_VERSION}:latest \
        bin/bash -c "cd ${PWD}; ./bin/php-cs-fixer $*"
}

function runPhpunit() {
    docker run \
        -u ${HOST_UID} \
        -v /bamboo-data/${BAMBOO_COMPOSE_PROJECT_NAME}/passwd:/etc/passwd \
        -v ${BAMBOO_COMPOSE_PROJECT_NAME}_bamboo-data:/srv/bamboo/xml-data/build-dir/ \
        -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} \
        -e HOME=${HOME} \
        -e typo3DatabaseName=${bamboo_typo3DatabaseName} \
        -e typo3DatabaseUsername=${bamboo_typo3DatabaseUsername} \
        -e typo3DatabasePassword=${bamboo_typo3DatabasePassword} \
        -e typo3DatabaseHost=${bamboo_typo3DatabaseHost} \
        --name ${BAMBOO_COMPOSE_PROJECT_NAME}sib_adhoc \
        --network ${BAMBOO_COMPOSE_PROJECT_NAME}_test \
        --rm \
        typo3gmbh/${TEST_PHP_VERSION}:latest \
        bin/bash -c "cd ${PWD}; ./bin/phpunit $*"
}
