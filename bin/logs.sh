#!/bin/bash

source ./bin/includes.sh

# From: http://patorjk.com/software/taag/#p=display&c=echo&f=Standard&t=Foo%20Bar
echo "  _____             ____             ";
echo " |  ___|__   ___   | __ )  __ _ _ __ ";
echo " | |_ / _ \ / _ \  |  _ \ / _\` | '__|";
echo " |  _| (_) | (_) | | |_) | (_| | |   ";
echo " |_|  \___/ \___/  |____/ \__,_|_|   ";
echo "                                     ";

echo -e "Here comes the logs in real-time ... $(action_format "done")"
echo ""

docker-compose logs -f
