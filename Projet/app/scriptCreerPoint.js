// Fonction pour créer les points à partir des données récupérées
function createPoints(data) {
    // Ajouter les points à la carte en utilisant les coordonnées du serveur
    for (var i = 0; i < data.length; i++) {
        createPoint(data[i].x, data[i].y, data[i].couleur, data[i].id);
    }
}

// Fonction pour créer un point
function createPoint(coordX, coordY, couleur, id) {
    // Création du point
    let point = document.createElement("div");
    point.className = "point";

    let originex = 1045; // Origine de la carte en x
    let originey = 250; // Origine de la carte en y

    // Positionnement du point aux coordonnées spécifiées avec translation
    point.style.left = coordX * (-40.5) + originex + "px";
    point.style.top = coordY * 37 + originey + "px";

    // Définir la couleur du point
    point.style.backgroundColor = couleur;

    // Ajout de l'id en dessous du point
    let idLabel = document.createElement("div");
    idLabel.className = "id-label";
    idLabel.innerText = id ? id : "";
    idLabel.style.userSelect = "none";

    // Ajout de l'événement de clic pour afficher ou masquer la boîte de dialogue
    point.addEventListener("click", function () {
        togglePopup(id, coordX, coordY);

        // Ajouter la classe transparent aux autres points
        toggleOtherPointsTransparency(point);
    });

    // Ajout de l'id en dessous du point
    point.appendChild(idLabel);

    // Ajout du point à la carte
    document.getElementById("map").appendChild(point);

    
}

// Fonction pour afficher ou masquer la boîte de dialogue
function togglePopup(id, coordX, coordY) {
    // Récupérer la boîte de dialogue et son contenu
    let popup = document.getElementById("popup");
    let popupContent = document.getElementById("popup-content");

    // Si la boîte de dialogue est déjà affichée, la masquer
    if (popup.style.display === "block") {
        popup.style.display = "none";
    } else {
        // Sinon, afficher les informations du point dans la boîte de dialogue
        showPopup(id, coordX, coordY);
    }
}

// Fonction pour afficher la boîte de dialogue
function showPopup(id, coordX, coordY) {
    // Récupérer la boîte de dialogue et son contenu
    let popup = document.getElementById("popup");
    let popupContent = document.getElementById("popup-content");

    // Remplacer le contenu de la boîte de dialogue avec les informations du point
    popupContent.innerHTML = "ID: " + id + "<br>X: " + coordX + "<br>Y: " + coordY;

    // Positionner la boîte de dialogue à côté du point cliqué
    let originex = 1045; // Origine de la carte en x
    let originey = 250; // Origine de la carte en y

    // Calculer la position de la boîte de dialogue par rapport au point cliqué
    let popupX = coordX * (-40.5) + originex + 20; // Ajuster la valeur 20 selon votre besoin
    let popupY = coordY * 37 + originey - 30; // Ajuster la valeur -20 selon votre besoin

    // Positionner la boîte de dialogue à la nouvelle position
    popup.style.left = popupX + "px";
    popup.style.top = popupY + "px";

    // Rendre la boîte de dialogue visible
    popup.style.display = "block";
}

document.addEventListener("DOMContentLoaded", function () {
    // Utiliser AJAX pour récupérer les données du serveur
    $.ajax({
        url: 'donnes.php', // Remplacez 'donnees.php' par le chemin correct vers votre script PHP
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Données récupérées avec succès :', data);

            // Les données sont récupérées avec succès
            // Appeler une fonction pour créer les points avec les données
            createPoints(data);
        },
        error: function (error) {
            console.error('Erreur de requête AJAX :', error);
        }
    });
});

// Fonction pour basculer la transparence des autres points
function toggleOtherPointsTransparency(clickedPoint) {
    let allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        if (point !== clickedPoint) {
            // Ajouter ou supprimer la classe transparent en fonction du clic
            point.classList.toggle("transparent");
        }
    });
}