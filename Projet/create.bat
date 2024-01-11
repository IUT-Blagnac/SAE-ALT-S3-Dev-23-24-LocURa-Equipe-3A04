REM Build de l'image Docker
docker build -t sae .

REM Exécution du conteneur Docker
docker run -v C:\Users\Fontanilles\OneDrive\Documents\GitHub\SAE-ALT-S3-Dev-23-24-LocURa-Equipe-4\Projet\app:/app -it -p 8080:80 sae
