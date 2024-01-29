import { X_ORIGINE_C, Y_ORIGINE_C,COEFF_X,COEFF_Y,POPUP_OFFSET_X,POPUP_OFFSET_Y } from '../DiversJavaScripts/constantes.js';

/**
 *  Fonction pour créer les points à partir des données récupérées
 * @param {Array} data 
 */
export function createPoints(data) {
    // Ajouter les points à la carte en utilisant les coordonnées du serveur
    for (var i = 0; i < data.length; i++) {
        createPoint(data[i]);
        console.log("Point : " + data[i].idCapteur+" / UID : "+data[i].UID +" / IDDWM : "+data[i].iddwm+ " créé avec succès");
    }
}

/**
 * Fonction pour mettre à jour les coordonnées d'un point existant
 * @param {HTMLDivElement} point Le point existant à mettre à jour
 * @param {Number} newCoordX La nouvelle coordonnée X
 * @param {Number} newCoordY La nouvelle coordonnée Y
 */0
 export function updatePointCoordinates(point, newCoordX, newCoordY) {
    // Mettre à jour la position du point avec les nouvelles coordonnées
    point.style.left = newCoordX * COEFF_X + X_ORIGINE_C + "px";
    point.style.top = newCoordY * COEFF_Y + Y_ORIGINE_C + "px";
}

const checkedCheckboxIds = [];

/**
 * Crée un point sur la carte
 * @param {Array} donneesPoint Array contenant les informations du point 
 */
function createPoint(donneesPoint) {
    // Création du point
    let point = document.createElement("div");
    point.className = "point";

    // Ajout de l'ID comme attribut au point
    point.setAttribute("id", donneesPoint.idCapteur);
    point.setAttribute("iddwm", donneesPoint.iddwm);
    point.setAttribute("uid", donneesPoint.UID);

    // Positionnement du point aux coordonnées spécifiées avec translation
    point.style.left = donneesPoint.x * COEFF_X + X_ORIGINE_C + "px";
    point.style.top = donneesPoint.y * COEFF_Y + Y_ORIGINE_C + "px";

    if (donneesPoint.color != null && donneesPoint.color != "") {
        point.style.backgroundColor = "#" +donneesPoint.color;
    } else {
        point.style.backgroundColor = "red";
    }

    // Ajout de l'id en dessous du point
    let idLabel = createIdLabel(); // Utiliser la fonction pour créer idLabel

    point.addEventListener("click", function () {
        togglePopup(point,donneesPoint);
    });

    // Ajouter le idLabel au point
    point.appendChild(idLabel);

    // Ajout du point à la carte
    document.getElementById("map").appendChild(point);
    
}

//#region Gestion Labels

/**
 * Crée un élément div pour afficher l'ID du point
 * @returns {HTMLDivElement} L'élément idLabel
 */
function createIdLabel() {
    let idLabel = document.createElement("div");
    idLabel.className = "id-label";
    idLabel.style.userSelect = "none";
    idLabel.style.position = "absolute";
    idLabel.style.top = "-1px";
    idLabel.style.left = "+25px";

    return idLabel;
}

/**
 *  Fonction pour changer le contenu de l'idLabel en fonction des checkboxes
 */ 
function updateIdLabelContent(point, showID, showUID, showDWM) {
    let idLabel = point.querySelector(".id-label");
    if (idLabel) {
        let content = "";

        if (showID) {
            content += point.getAttribute("id")+"\n";
        }
        if (showUID) {
            content +=point.getAttribute("uid")+"\n";
        }
        if (showDWM) {
            content +=point.getAttribute("iddwm")+"\n";
        }

        idLabel.textContent = content.trim();
    }
}

//#endregion

//#region Gestion Popup

/**
 * Affiche la boîte de dialogue en fonction du point cliqué
 * @param {HTMLDivElement} clickedPoint Le point cliqué
 * @param {Array} donneesPoint Array contenant les informations du point cliqué
 */
function togglePopup(clickedPoint,donneesPoint) {

    let popup = document.getElementById("popup");
    
    // Si la boîte de dialogue est déjà affichée pour ce point, on la cache
    if (clickedPoint.classList.contains("selected")) {
        // Cacher la boîte de dialogue
        popup.style.display = "none";
        console.log(popup.style.display);

        // Réinitialiser la transparence de tous les points
        resetPointsTransparency();
        updateTransparencyBasedOnCheckboxes(checkedCheckboxIds);
        console.log("Point : " + id + " masqué avec succès");
    } else {
        // Sinon, afficher les informations du point dans la boîte de dialogue
        showPopup(donneesPoint);
        // Mettre à jour les classes des points pour indiquer la sélection
        updatePointSelection(clickedPoint);
        // Retirer la classe transparent du point sélectionné
        clickedPoint.classList.remove("transparent");
        // Ajouter la classe transparent aux autres points
        toggleOtherPointsTransparency(clickedPoint);
    }
}

/**
 * Crée une boîte de dialogue avec les informations du point cliqué
 * @param {Array} donneesPoint Array contentant les informations du point cliqué
 */
function showPopup(donneesPoint) {
    // Récupérer la boîte de dialogue et son contenu
    let popup = document.getElementById("popup");
    let popupContent = document.getElementById("popup-content");

    let resultString = '';

    for (const key in donneesPoint) {
        if (donneesPoint.hasOwnProperty(key)) {
            resultString += `${key} : ${donneesPoint[key]}<br>`;
        }
    }

    if (resultString !== '') {
        resultString = resultString.slice(0, -4); // Retire le dernier <br>
    }

    // Remplacer le contenu de la boîte de dialogue avec les informations du point
    popupContent.innerHTML = resultString;

    // Calculer la position de la boîte de dialogue par rapport au point cliqué
    let popupX = donneesPoint.x * COEFF_X + X_ORIGINE_C + POPUP_OFFSET_X;
    let popupY = donneesPoint.y * COEFF_Y + Y_ORIGINE_C + POPUP_OFFSET_Y; 

    // Positionner la boîte de dialogue à la nouvelle position
    popup.style.left = popupX + "px";
    popup.style.top = popupY + "px";

    // Rendre la boîte de dialogue visible
    popup.style.display = "block";
}



//#endregion

/**
 * Réinitialise la transparence de tous les points
 */
function resetPointsTransparency() {
    
    let allPoints = document.querySelectorAll(".point");
    let popup = document.getElementById("popup");

    
    
    // Parcourir tous les points
    allPoints.forEach(function (point) {
        // Supprimer la classe selected de tous les points
        point.classList.remove("selected");
        // Supprimer la classe transparent de tous les points
        point.classList.remove("transparent");
        point.classList.remove("transparenttotal");
        popup.style.display = "none";

        if (point.clickHandler) {
            let clickHandler = function () {
                togglePopup(point, point.id, point.coordX, point.coordY);
            };
        point.addEventListener("click", clickHandler);
        point.clickHandler = clickHandler;
        }
    });
    
}

/**
 * Permet de mettre à jour la sélection des points
 * @param {HTMLDivElement} clickedPoint 
 */
function updatePointSelection(clickedPoint) {
    let allPoints = document.querySelectorAll(".point");

    // Parcourir tous les points
    allPoints.forEach(function (point) {
        // Ajouter ou supprimer la classe selected en fonction du clic
        point.classList.toggle("selected", point === clickedPoint);
    });
}

/**
 * Fonction pour basculer la transparence des autres points
 * 
 * @param {*} clickedPoint : Le point cliqué
 */
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

/**
 * Fonction pour mettre à jour la transparence des points en fonction des cases à cocher
 * @param {*} checkedCheckboxIds : Les identifiants des cases cochées 
 */
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
        let popup = document.getElementById("popup");

        // Vérifier si le point est associé à une case cochée
        let isAssociated = checkedCheckboxIds.includes(pointID);
        if (isAssociated) {
            // Si associé, afficher le point en supprimant la classe transparenttotal
            point.classList.remove("transparenttotal");
        } else {
            // Sinon, appliquer la classe transparenttotal
            point.classList.add("transparenttotal");
            popup.style.display = "none";
            console.log(popup.style.display);

        }
    });
}

/**
 * Permet de trier les noeuds de la dropdown en fonction de leur état de sélection
 */
function trierNoeudSiCoche() {
    // Divisez les nœuds en deux tableaux, un pour les cochés et un pour les non cochés
    var checkedNodes = [];
    var uncheckedNodes = [];

    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            checkedNodes.push(checkbox.parentElement);
        } else {
            uncheckedNodes.push(checkbox.parentElement);
        }
    });

    // Triez les nœuds cochés en premier
    var sortedNodes = checkedNodes.concat(uncheckedNodes);

    // Supprimez tous les nœuds du conteneur
    var nodesContainer = document.getElementById('nodes');
    nodesContainer.innerHTML = '';

    // Ajoutez les nœuds triés au conteneur
    sortedNodes.forEach(function (node) {
        nodesContainer.appendChild(node);
    });
    
}

// Sélectionner toutes les cases à cocher dans le menu déroulant
var checkboxes = document.querySelectorAll('#nodes input[type="checkbox"]');

// Desactivation de la popup en clickant en dehors de la popup
document.addEventListener('click', function (event) {
    let popup = document.getElementById("popup");

    // Vérifiez si la cible du clic n'est pas à l'intérieur de la boîte de dialogue
    if (!popup.contains(event.target) && !event.target.classList.contains("point")) {
        // Masquer la boîte de dialogue
        popup.style.display = "none";
        // Réinitialiser la transparence de tous les points
        resetPointsTransparency();
        updateTransparencyBasedOnCheckboxes(checkedCheckboxIds);
    }
});


document.addEventListener('DOMContentLoaded', function () {
    var checkboxesNodes = document.querySelectorAll('.node-container input[type="checkbox"]');

    // Tri initial au chargement de la page
    trierNoeudSiCoche();

    checkboxesNodes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            // Update the checkedCheckboxIds array based on checkbox changes
            checkedCheckboxIds.length = 0; // Clear the array
            checkedCheckboxIds.push(...Array.from(checkboxesNodes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.getAttribute('data-node-id')));
    
            // Call updateTransparencyBasedOnCheckboxes with the updated checkedCheckboxIds
            updateTransparencyBasedOnCheckboxes(checkedCheckboxIds);
    
            // Sort the nodes after each checkbox change
            trierNoeudSiCoche();

            console.log("checkedCheckboxIds: " + checkedCheckboxIds);
        });
    });

    
    // Exemple d'utilisation de la fonction changeIdLabelContent après le clic sur une checkbox
    let checkboxes = document.querySelectorAll(".dropdown-content input[type='checkbox']");
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            let showID = document.getElementById("selectID").checked;
            let showUID = document.getElementById("selectUID").checked;
            let showDWM = document.getElementById("selectDWM").checked;

            // Obtenez tous les points existants
            let points = document.querySelectorAll(".point");

            console.log("showID: " + showID);
            console.log("showUID: " + showUID);
            console.log("showDWM: " + showDWM);
            points.forEach(function (point) {
                updateIdLabelContent(point, showID, showUID, showDWM);
            });
        });
    });
});

// Afficher le bouton unselect all si au moins un noeud est sélectionné
function checkIfAnyNodeIsChecked() {
    var checkboxes = document.querySelectorAll('#nodes input[type="checkbox"]');
    var isAnyNodeChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    var unselectAllButton = document.getElementById('unselectAll');
    if (isAnyNodeChecked) {
        unselectAllButton.style.display = 'block';
        unselectAllButton.style.position = 'absolute';
    } else {
        unselectAllButton.style.display = 'none';
    }
}

// Appeler la fonction chaque fois qu'une case à cocher est cliquée
document.querySelectorAll('#nodes input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', checkIfAnyNodeIsChecked);
});

// Appeler la fonction au chargement de la page pour initialiser l'état du bouton
checkIfAnyNodeIsChecked();

/**
 * Fonction pour désélectionner tous les nœuds et afficher tous les noeuds
 */
function unselectAllNodes() {
    // Désélectionner toutes les cases à cocher
    document.querySelectorAll('#nodes input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.checked = false;
        checkedCheckboxIds.length = 0;
    });
    updateTransparencyBasedOnCheckboxes(checkedCheckboxIds);

    // Cacher le bouton unselect all
    document.getElementById('unselectAll').style.display = 'none';
}

// Appeler la fonction lorsque le bouton est cliqué
document.getElementById('unselectAll').addEventListener('click', unselectAllNodes);

function checkIfLayersAreChecked() {
    var layers = document.querySelectorAll('#layers input[type="checkbox"]');
    var isAnyLayerChecked = Array.from(layers).some(layer => layer.checked);
    let points = document.querySelectorAll(".point");

    points.forEach(function (point) {
        if (!isAnyLayerChecked) {
            point.classList.add("transparenttotal");
        } else {
            point.classList.remove("transparenttotal");
        }
    })
}

// Appeler la fonction chaque fois qu'une case est cochée ou décochée
document.querySelectorAll('#layers input[type="checkbox"]').forEach(function(layer) {
    layer.addEventListener('change', checkIfLayersAreChecked);
});