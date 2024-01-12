// Fonction pour créer les points à partir des données récupérées
function createPoints(data) {
    // Ajouter les points à la carte en utilisant les coordonnées du serveur
    for (var i = 0; i < data.length; i++) {
        console.log(data); // Ajout pour afficher les données dans la console

        createPoint(data[i].x, data[i].y, 'red'); // Vous pouvez ajuster la couleur selon vos besoins
    }
}

// Fonction pour créer un point
function createPoint(coordX, coordY, couleur) {
    // Création du point
    let point = document.createElement("div");
    point.className = "point";

    let origine = 100; // Origine de la carte

    // Positionnement du point aux coordonnées spécifiées avec translation
    point.style.left = coordX + origine + "px";
    point.style.top = coordY + origine + "px";

    // Définir la couleur du point
    point.style.backgroundColor = couleur;

    // Ajout du point à la carte
    document.getElementById("map").appendChild(point);
}
