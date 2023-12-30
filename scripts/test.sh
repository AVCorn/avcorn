#!/bin/bash

echo "Testing..."

STEP="${1:-all}"
SCRIPT_DIRECTORY="$(dirname $(realpath "$0"))"

case $STEP in

    "all")
        php "$SCRIPT_DIRECTORY/../code/vendor/bin/codecept" run --steps -c "$SCRIPT_DIRECTORY/../code/codeception.yml"
        php "$SCRIPT_DIRECTORY/../code/vendor/bin/phpbench" run "$SCRIPT_DIRECTORY/../tests/Benchmark" --report=default
    ;;

    "unit")
        php "$SCRIPT_DIRECTORY/../code/vendor/bin/phpunit" "$SCRIPT_DIRECTORY/../tests/Unit/"
    ;;

    "coverage")
        php -d xdebug.mode=coverage "$SCRIPT_DIRECTORY/../code/vendor/bin/phpunit" "$SCRIPT_DIRECTORY/../tests/unit/" --coverage-html "$SCRIPT_DIRECTORY/../docs/coverage"
    ;;

    "acceptance")
        php "$SCRIPT_DIRECTORY/../code/vendor/bin/codecept" run acceptance -c "$SCRIPT_DIRECTORY/../code/codeception.yml"
    ;;

    "benchmark")
        php "$SCRIPT_DIRECTORY/../code/vendor/bin/phpbench" run --config=phpbenchmark.json --report=default
    ;;
esac

echo "Testing complete!";