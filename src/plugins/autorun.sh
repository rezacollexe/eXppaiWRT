#!/bin/bash

cd /root/XppaiWRT
screen -r -S "bot" -X quit 2>/dev/null
screen -S bot "php-cli index.php"
