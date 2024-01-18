<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="navbar">
    <a href="https://www.irit.fr/plateformes/plateforme-locura4iot/">A propos</a>

    <div class="dropdown">
        <button class="dropbtn"> Noeuds
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="nodes">
            <label><input type="checkbox" id="node0"> Origine</label>
            <label><input type="checkbox" id="node1"> Noeud 17</label>
            <label><input type="checkbox" id="node2"> Noeud 18</label>
            <label><input type="checkbox" id="node3"> Noeud 25</label>
            <label><input type="checkbox" id="node4"> Noeud 69</label>
            <label><input type="checkbox" id="node5"> Noeud 177</label>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn"> Couches
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="layers">
            <label><input type="checkbox" name="firstLayer" id="firstLayer"> Couche 1 </label>
            <label><input type="checkbox" name="secondLayer" id="secondLayer"> Couche 2 </label>
            <label><input type="checkbox" name="thirdLayer" id="thirdLayer"> Couche 3 </label>
        </div>
    </div>
</div>

<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Inclure le fichier JavaScript pour AJAX -->
<script src="scriptRecupererDonnes.js"></script>
<!-- Inclure le fichier JavaScript pour créer les points -->
<script src="scriptCreerPoint.js" ></script>
<!-- Inclure le fichier JavaScript pour les couches -->
<script src="ajaxRequestToDataPHP.js" ></script>
<!-- Inclure le fichier JavaScript pour les nœuds -->
<script src="scriptAfficherPoints.js"></script>

<img id="map-image" class="map-image">

<div id="map-container"></div>

<div id="map"></div>

<!-- Ajoutez cette balise div à l'endroit où vous souhaitez afficher la boîte de dialogue -->
<div id="popup" class="popup">
    <div id="popup-content" class="popup-content">
        <!-- Le contenu de la boîte de dialogue sera affiché ici -->
    </div>
</div>

<script>
    // Attendre que le document soit prêt

</script>
</body>
</html>
