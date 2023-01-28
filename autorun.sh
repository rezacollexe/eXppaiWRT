#!/bin/bash

cd /root/XppaiWRT
pkill php-cli
#sleep 6;
nohup /usr/bin/php-cli /root/XppaiWRT/index.php &
