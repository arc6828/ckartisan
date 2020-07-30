#!/bin/bash
if [[ ! "$(/usr/sbin/service mysql status)" =~ "running" ]]
then
    echo "RESTART"
    #RESTART
    /usr/sbin/service mysql start
    #LOG IN DB
    php artisan mysql:logrestart
else 
    echo "RUNNING"
fi
