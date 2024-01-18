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
            <label><input type="checkbox" id="node17"> Noeud 17</label>
            <label><input type="checkbox" id="node18"> Noeud 18</label>
            <label><input type="checkbox" id="node25"> Noeud 25</label>
            <label><input type="checkbox" id="node69"> Noeud 69</label>
            <label><input type="checkbox" id="node177"> Noeud 177</label>
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

<img id="map-image" class="map-image">

<div id="map-container" class="map-container"></div>

<div id="map"></div>

<!-- Afficher la popup du noeud -->
<div id="popup" class="popup">
    <div id="popup-content" class="popup-content"></div>
</div>
</body>
</html>
