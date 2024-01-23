REM Exécution du conteneur Docker
docker-compose up -d

REM On lance les commandes dans le containeur serveurweb
docker exec -d ServeurWeb php -f connexionMQTT.php