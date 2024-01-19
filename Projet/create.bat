REM Build de l'image Docker
docker-compose build

REM Exécution du conteneur Docker
docker-compose up -d

REM On lance les commandes dans le containeur serveurweb
docker exec -it ServeurWeb php -f connexionMQTT.php &