<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="navbar">
    <div class="dropdown">
        <button class="dropbtn"> Environnement
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="environment">
            <label><input type="checkbox" name="batA" id="batA"> Bâtiment A </label>
            <label><input type="checkbox" name="batC" id="batC"> Bâtiment C </label>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn"> Etages
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="layers">
            <label><input type="checkbox" name="premiereEtage" id="premiereEtage"> Etage 1 </label>
            <label><input type="checkbox" name="deuxiemeEtage" id="deuxiemeEtage"> Etage 2 </label>
            <label><input type="checkbox" name="troisiemeEtage" id="troisiemeEtage"> Etage 3 </label>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn"> Noeuds
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="nodes">
            <label><input type="checkbox" id="nodeOrigine"> Origine</label>
            <label><input type="checkbox" id="node17"> Noeud 17</label>
            <label><input type="checkbox" id="node18"> Noeud 18</label>
            <label><input type="checkbox" id="node25"> Noeud 25</label>
            <label><input type="checkbox" id="node69"> Noeud 69</label>
            <label><input type="checkbox" id="node177"> Noeud 177</label>
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
