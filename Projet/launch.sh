#!/bin/bash

docker-compose up -d

sleep 2

docker exec -d ServeurWeb php -f connexionMQTT.php