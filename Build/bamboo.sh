#!/bin/bash
if [ "$(ps -p "$$" -o comm=)" != "bash" ]; then
    bash "$0" "$@"
    exit "$?"
fi

# fail immediately if some command failed
set -e
# output all commands
set -x

# Create log directory
mkdir -p logs

# lint, phpunit, composer in docker helper functions
source Build/bamboo-container-functions.sh

# load php version to test
source Build/php_versions.sh

for TEST_PHP_VERSION in "${PHP_VERSIONS[@]}"; do
    # Check for PHP Errors
    runLint

    # Composer install dependencies using docker function
    runComposer install --no-interaction --no-progress

    # CGL Checks
    # Disabled for now since php-cs-fixer is not available
    runPhpCsFixer fix --config Build/.php_cs.dist --format=junit > logs/php-cs-fixer.xml

    # Unit tests
    runPhpunit -c Build/UnitTests.xml --log-junit logs/phpunit.xml  --coverage-clover logs/coverage.xml --coverage-html logs/coverage/

    # Functional tests
    # runPhpunit -c Build/FunctionalTests.xml --log-junit logs/functional.xml  --coverage-clover logs/coverage-functionals.xml --coverage-html logs/coverage-functionals/
done
