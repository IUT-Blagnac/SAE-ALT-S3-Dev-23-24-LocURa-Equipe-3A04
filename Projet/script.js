document.addEventListener("DOMContentLoaded", function() {
    function creerPoint(coordX, coordY, couleur) {
        // Création du point
        let point = document.createElement("div");
        point.className = "point";
        
        let originex = 500;
        let originey = 500;

        point.style.backgroundColor = couleur;


        // Positionnement du point aux coordonnées spécifiées avec translation
        point.style.left = coordX + originex + "px";
        point.style.top = coordY + originey + "px";

        // Ajout du point à la carte
        document.getElementById("map").appendChild(point);
    }

    // Exemple d'utilisation avec des coordonnées différentes
    creerPoint(0, 0,"green");   // Origine (500, 500) + (0, 0) = (500, 500)
    creerPoint(100, 200,"red"); // Origine (500, 500) + (100, 200) = (600, 700)
    creerPoint(-50, 100,"purple"); // Origine (500, 500) + (-50, 100) = (450, 600)
});