
// Fonction pour créer les points à partir des données récupérées
function createPoints(data) {
    // Ajouter les points à la carte en utilisant les coordonnées du serveur
    for (var i = 0; i < data.length; i++) {
        createPoint(data[i].x, data[i].y, data[i].color, data[i].idCapteur, "dwm1001-82");
        console.log("Point : " + data[i].idCapteur + " crée avec succès");
    }
}

// Fonction pour créer un point
function createPoint(coordX, coordY, couleur, id, iddwm, target) {
    // Création du point
    let point = document.createElement("div");
    point.className = "point";

    // Ajout de l'ID comme attribut au point
    point.setAttribute("id", id);

    let originex = 1045; // Origine de la carte en x
    let originey = 250; // Origine de la carte en y
    let coeffx = -40.5;
    let coeffy = 37;

    // Positionnement du point aux coordonnées spécifiées avec translation
    point.style.left = coordX * coeffx + originex + "px";
    point.style.top = coordY * coeffy + originey + "px";

    if (couleur != null && couleur != "") {
        point.style.backgroundColor = "#" + couleur;
    } else {
        point.style.backgroundColor = "red";
    }

    // Ajout de l'id en dessous du point
    let idLabel = document.createElement("div");
    idLabel.className = "id-label";
    idLabel.style.userSelect = "none";
    idLabel.style.position = "absolute";
    idLabel.style.top = "-1px";
    idLabel.style.left = "+22px";

    // let iddwmLabel = document.createElement("div");
    // iddwmLabel.className = "id-label";
    // iddwmLabel.style.userSelect = "none";
    // iddwmLabel.style.position = "absolute";
    // iddwmLabel.style.top = "-1px";
    // iddwmLabel.style.left = "+15px";

    


    console.log("idLabelBefore : " + idLabel);

    // let iddwmLabelText; // Variable pour stocker le texte de l'idLabel
    let idLabelText; // Variable pour stocker le texte de l'idLabel

    // iddwmLabelText = iddwm.replace("dwm1001-", "");
    if (id.startsWith("dwm1001-")) {
        // Si oui, extraire le nombre de l'ID en supprimant le préfixe
        idLabelText = id.replace("dwm1001-", "");
    } else {
        // Si non, utiliser directement l'ID comme le nombre
        idLabelText = id;
    }
    

    // Ajout de l'événement de clic pour afficher ou masquer la boîte de dialogue
    point.addEventListener("click", function () {
        togglePopup(point, id, coordX, coordY, target);
    });

    // Créer un nouvel élément TextNode avec la valeur de idLabelText
    var textNode = document.createTextNode(idLabelText);

    // Ajouter le TextNode à l'élément idLabel
    idLabel.appendChild(textNode);

    // Créer un nouvel élément TextNode avec la valeur de iddwmLabelText
    // var textNodedwm = document.createTextNode(iddwmLabelText);

    // Ajouter le TextNode à l'élément idLabel
    // iddwmLabel.appendChild(textNodedwm);

    console.log("idLabel : " + idLabel.textContent);
    // Ajouter l'idLabel au point
    point.appendChild(idLabel);
    // point.appendChild(iddwmLabel);

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
        // Retirer la classe transparent du point sélectionné
        clickedPoint.classList.remove("transparent");
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

    let idNumber;
    if (id.startsWith("dwm1001-")) {
        // Si oui, extraire le nombre de l'ID en supprimant le préfixe
        idNumber = id.replace("dwm1001-", "");
    } else {
        // Si non, utiliser directement l'ID comme le nombre
        idNumber = id;
    }
    
    // Remplacer le contenu de la boîte de dialogue avec les informations du point
    popupContent.innerHTML = "ID: " + idNumber + "<br>X: " + coordX + "<br>Y: " + coordY;

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
        point.classList.remove("transparenttotal");

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
        }
    });

}


function toggleOtherPointsTransparencyTotal(clickedPoint) {
    let allPoints = document.querySelectorAll(".point");

    var clickedPointID = clickedPoint.replace("node", "");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        // Récupérer l'ID du point en cours
        let currentPointID = point.id;
        // Ajouter ou supprimer la classe transparent en fonction du clic
        if (currentPointID !== clickedPointID) {
            point.classList.add("transparenttotal");
            point.classList.remove("opacity");
        } else {
            point.classList.remove("transparenttotal");
        }
    });
}

function updateTransparencyBasedOnCheckboxes(checkedCheckboxIds) {

    let allPoints = document.querySelectorAll(".point");

    if (checkedCheckboxIds.length === 0) {
        // Si aucune case n'est cochée, réinitialiser la transparence de tous les points
        resetPointsTransparency();
        return;
    }

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        let pointID = point.id.replace("dwm1001-", "");
        // Vérifier si le point est associé à une case cochée
        let isAssociated = checkedCheckboxIds.includes(pointID);
        console.log(checkedCheckboxIds);
        console.log("Point ID:", pointID, "Is Associated:", isAssociated);
        if (isAssociated) {
            console.log("Point ID:", pointID, "Is Associated:", isAssociated);
            // Si associé, afficher le point en supprimant la classe transparenttotal
            point.classList.remove("transparenttotal");
        } else {
            console.log("Transparent");
            // Sinon, appliquer la classe transparenttotal
            point.classList.add("transparenttotal");
        }
    });
}

// Sélectionnez toutes les cases à cocher dans le menu déroulant
var checkboxes = document.querySelectorAll('#nodes input[type="checkbox"]');

// Ajoutez un écouteur d'événements à chaque case à cocher
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        checkbox.id = checkbox.id.replace("node", "");

        console.log("Checkbox changed:", checkbox.id, "Checked:", checkbox.checked);


        // Obtenez tous les identifiants des cases à cocher cochées
        let checkedCheckboxIds = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.id);

        // Appelez updateTransparencyBasedOnCheckboxes avec les identifiants des cases cochées
        updateTransparencyBasedOnCheckboxes(checkedCheckboxIds);
    });
});