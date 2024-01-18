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
        togglePopup(point, id, coordX, coordY);
    });

    // Ajout de l'id en dessous du point
    point.appendChild(idLabel);

    // Ajout du point à la carte
    document.getElementById("map").appendChild(point);
}

// Fonction pour afficher ou masquer la boîte de dialogue
function togglePopup(clickedPoint, id, coordX, coordY) {
    // Récupérer la boîte de dialogue et son contenu
    let popup = document.getElementById("popup");
    let popupContent = document.getElementById("popup-content");

    // Vérifier si la boîte de dialogue est déjà affichée pour le même point
    if (clickedPoint.classList.contains("selected")) {
        // Cacher la boîte de dialogue
        popup.style.display = "none";
        // Réinitialiser la transparence de tous les points
        resetPointsTransparency();
    } else {
        // Sinon, afficher les informations du point dans la boîte de dialogue
        showPopup(id, coordX, coordY);
        // Mettre à jour les classes des points pour indiquer la sélection
        updatePointSelection(clickedPoint);
        // Retirer la classe transparent du point sélectionné
        clickedPoint.classList.remove("transparent");
        // Ajouter la classe transparent aux autres points
        toggleOtherPointsTransparency(clickedPoint);
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

// Fonction pour réinitialiser la transparence de tous les points
function resetPointsTransparency() {
    let allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        // Supprimer la classe selected de tous les points
        point.classList.remove("selected");
        // Supprimer la classe transparent de tous les points
        point.classList.remove("transparent");

        if (!point.clickHandler) {
            let clickHandler = function () {
                togglePopup(point, id, coordX, coordY);
            };
            point.addEventListener("click", clickHandler);
            point.clickHandler = clickHandler;
        }
    });
    
}

// Fonction pour mettre à jour les classes des points pour indiquer la sélection
function updatePointSelection(clickedPoint) {
    let allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        // Ajouter ou supprimer la classe selected en fonction du clic
        point.classList.toggle("selected", point === clickedPoint);
    });
}

// Fonction pour basculer la transparence des autres points
function toggleOtherPointsTransparency(clickedPoint) {
    let allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        
        // Ajouter ou supprimer la classe transparent en fonction du clic
        if (point !== clickedPoint) {
            point.classList.add("transparent");
            point.classList.remove("opacity");
        } else {
            point.classList.remove("transparent");
            point.classList.add("opacity");
        }
    });

}


// Fonction pour basculer la transparence des autres points
function toggleOtherPointsTransparencyTotal(clickedPoint) {
    let allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        // Ajouter ou supprimer la classe transparent en fonction du clic
        point.classList.toggle("transparenttotal", point !== clickedPoint);
        point.removeEventListener('click', function () {
            togglePopup(point, id, coordX, coordY);
        });
    });
}

// Fonction pour mettre à jour la transparence en fonction des cases cochées
function updateTransparencyBasedOnCheckboxes() {
    // Sélectionnez toutes les cases à cocher dans le menu déroulant
    var checkboxes = document.querySelectorAll('.dropdown-content input[type="checkbox"]');
    
    // Récupérez les points associés à chaque case à cocher
    var points = [];
    checkboxes.forEach(function (checkbox, index) {
        if (checkbox.checked) {
            // Ajoutez le point correspondant à la liste
            points.push(index);
        }
    });

    // Sélectionnez tous les points sur la carte
    var allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point, index) {
        // Vérifiez si le point doit être transparent ou non
        var shouldBeTransparent = points.length > 0 && points.indexOf(index) === -1;
        point.classList.toggle("transparenttotal", shouldBeTransparent);
    });
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

    // Sélectionnez toutes les cases à cocher dans le menu déroulant
    var checkboxes = document.querySelectorAll('.dropdown-content input[type="checkbox"]');

    // Ajoutez un écouteur d'événements à chaque case à cocher
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            // Appelez toggleOtherPointsTransparencyTotal en fonction des cases cochées
            updateTransparencyBasedOnCheckboxes();
        });
    });
});

