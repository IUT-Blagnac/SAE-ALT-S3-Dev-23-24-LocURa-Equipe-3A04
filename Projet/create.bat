REM Build de l'image Docker
docker build -t sae .

REM Exécution du conteneur Docker
docker run -it -p 8080:80 sae