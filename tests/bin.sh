#!/bin/bash
# Usage: ./tests/bin.sh xdebug_on /srv/www/wordpress-develop/public_html/src/wp-content/plugins/foo-bar
# Runs the PHPUnit tests with html coverage output.

set -e

if [ $# != 2 ]; then
	echo "You must supply two arguments, the xdebug command and vvv plugin path."
	exit 1
fi

if [ -z "$1" ]; then
	echo "Provide the xdebug command argument"
	exit 1
fi

if [ -z "$2" ]; then
	echo "Provide the vvv plugin path argument"
	exit 1
fi

if [ $1 = "xdebug_on" ]; then
    COVERAGE="--coverage-html /srv/www/default/coverage/foo-bar";
fi

vagrant ssh -c "$1 && cd $2 && WP_TESTS_DIR=vendor/xwp/wordpress-tests/phpunit phpunit $COVERAGE"
