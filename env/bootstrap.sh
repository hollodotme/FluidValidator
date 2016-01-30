#!/usr/bin/env bash

# link the uploaded nginx config to enable it
echo -e "\e[0m--"
rm -rf /etc/nginx/sites-enabled/*
for vhost in default pma; do
    ln -sf /etc/nginx/sites-available/$vhost /etc/nginx/sites-enabled/020-$vhost
    test -L /etc/nginx/sites-enabled/020-$vhost && echo -e "\e[0mLinking nginx $vhost config: \e[1;32mOK\e[0m" || echo -e "Linking nginx $vhost config: \e[1;31mFAILED\e[0m";
done

# restart nginx
echo -e "\e[0m--"
service nginx restart

# Determine the public ip address and show a message
IP_ADDR=`ifconfig eth1 | grep inet | grep -v inet6 | awk '{print $2}' | cut -c 6-`
PROJECT_NAME="fluid-validator"

echo -e "\e[0m--\nAdd to your /etc/hosts:\n\n\e[1;31m$IP_ADDR\twww.$PROJECT_NAME.de pma.$PROJECT_NAME.de\e[0m\n"
echo -e "\e[0m--\nRun \e[1;31mvagrant ssh\e[0m"
echo -e "\e[0m--\nRun \e[1;31mphp /vagrant/build/tools/composer.phar -d=/vagrant update -o -v\e[0m"
echo -e "\e[0m--\nBrowse application under \e[1;31mhttp://www.$PROJECT_NAME.de\e[0m"
echo -e "\e[0m--\nBrowse MySQL under \e[1;31mhttp://pma.$PROJECT_NAME.de\e[0m"
