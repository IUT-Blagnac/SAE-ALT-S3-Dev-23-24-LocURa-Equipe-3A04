REM Exécution du conteneur Docker
docker-compose up -d

REM On attends pour laisser le temps au conteneur de se lancer
timeout /t 2 /nobreak

REM On lance les commandes dans le containeur serveurweb
docker exec -d ServeurWeb php -f ScriptsExecutables/connexionMQTT.php