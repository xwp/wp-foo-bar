#!/bin/bash

source .env
source ./bin/includes.sh

##
# WordPress helper
#
# Executes a request in the WordPress container.
##
function is_wp_available() {
	if command_exists "curl"; then
        RESULT=`curl -w "%{redirect_url}" -o /dev/null -s localhost:8088`

        if [[ '' != "$RESULT" ]]; then
			return 0
		else
			return 1
		fi
	fi

	echo -e "$(error_message "The $(action_format "curl") command is not installed on your host machine.")"
	echo -e "$(warning_message "Checking that WordPress has been installed has failed.")"
	echo -e "$(warning_message "It could take a minute for the Database to become available.")"

	return 0
}

# Start the containers.
docker-compose up -d

# Check for WordPress.
until is_wp_available; do
	echo -e "$(warning_message "Waiting for WordPress to become available") $(action_format "...")"
	sleep 5
done

echo ""
echo "$(action_format "Welcome to ...")"

# From: http://patorjk.com/software/taag/#p=display&c=echo&f=Standard&t=Foo%20Bar
echo "  _____             ____             ";
echo " |  ___|__   ___   | __ )  __ _ _ __ ";
echo " | |_ / _ \ / _ \  |  _ \ / _\` | '__|";
echo " |  _| (_) | (_) | | |_) | (_| | |   ";
echo " |_|  \___/ \___/  |____/ \__,_|_|   ";
echo "                                     ";

# Give the user more context to what they should do next: Build the plugin and start testing!
echo -e "Run $(action_format "npm run dev") to build the latest version of the Foo Bar plugin,"
echo -e "then open $(action_format "http://localhost:8088/") to get started!"
echo ""
