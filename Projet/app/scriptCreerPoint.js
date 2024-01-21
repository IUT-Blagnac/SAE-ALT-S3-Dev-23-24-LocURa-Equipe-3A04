
// Fonction pour créer les points à partir des données récupérées
function createPoints(data) {
    // Ajouter les points à la carte en utilisant les coordonnées du serveur
    for (var i = 0; i < data.length; i++) {
        createPoint(data[i].x, data[i].y, data[i].color, data[i].idCapteur);
        console.log("Point : " + data[i].idCapteur+ " crée avec succès");
    }
}

// Fonction pour créer un point
function createPoint(coordX, coordY, couleur, id,target) {
    // Création du point
    let point = document.createElement("div");
    point.className = "point";

    let originex = 1045; // Origine de la carte en x
    let originey = 250; // Origine de la carte en y

    // Positionnement du point aux coordonnées spécifiées avec translation
    point.style.left = coordX * (-40.5) + originex + "px";
    point.style.top = coordY * 37 + originey + "px";

    
    if(couleur!=null && couleur!="")
    {
        point.style.backgroundColor = "#"+couleur;
    }
    else 
    {
        point.style.backgroundColor = "red";
    }
    console.log("Style : " + point.style.left);
    console.log("Style : " + point.style.top);
    console.log("Style : " + point.style.backgroundColor);

    // Ajout de l'id en dessous du point
    let idLabel = document.createElement("div");
    idLabel.className = "id-label";
    idLabel.innerText = id ? id : "";
    idLabel.style.userSelect = "none";

    // Ajout de l'événement de clic pour afficher ou masquer la boîte de dialogue
    point.addEventListener("click", function () {
        togglePopup(point, id, coordX, coordY,target);
    });
    // Ajout de l'id en dessous du point
    point.appendChild(idLabel);

    // Ajout du point à la carte
    document.getElementById("map").appendChild(point);
    
}

// Fonction pour afficher ou masquer la boîte de dialogue
function togglePopup(clickedPoint, id, coordX, coordY,target) {
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
        // Ajouter la classe transparent aux autres points
        toggleOtherPointsTransparency(clickedPoint);
        toggleSignaling(id,target);
    }
}

function toggleSignaling(id,target) {
    let clickedPoint = document.getElementById(id);

    // Vérifier si le point cliqué est le point spécifique que vous souhaitez signaler
    if (id === target) {
        isSignaling = !isSignaling;

        // Si le signal est activé, ajouter une classe pour indiquer l'état de signalisation
        clickedPoint.classList.toggle("signaling", isSignaling);
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
        point.classList.toggle("transparent", point !== clickedPoint);
    });
}
