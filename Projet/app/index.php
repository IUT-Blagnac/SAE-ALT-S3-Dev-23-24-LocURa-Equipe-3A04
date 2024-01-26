<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>




<div class="navbar">
    <!-- Bouton qui permet d'afficher différents environnements - Non implémenté
    <div class="dropdown">
        <button class="dropbtn"> Environnement
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="environment">
            <label><input type="checkbox" name="batA" id="batA"> Bâtiment A </label>
            <label><input type="checkbox" name="batC" id="batC"> Bâtiment C </label>
        </div>
    </div>
    -->

    <!-- Bouton qui permet d'afficher différents étages d'un même environnement -->
    <div class="dropdown">
        <button class="dropbtn"> Etages
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="layers">
            <label><input type="checkbox" name="premierEtage" id="premierEtage" checked> Etage 1 </label>
            <label><input type="checkbox" name="deuxiemeEtage" id="deuxiemeEtage"> Etage 2 </label>
            <label><input type="checkbox" name="troisiemeEtage" id="troisiemeEtage"> Etage 3 </label>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn"> Noeuds
            <i class="fa fa-caret-down"></i>
        </button>
        <input type="text" id="searchInput" onkeyup="filterNodes()" placeholder="Rechercher par ID..."><br>

        <div class="dropdown-content" id="nodes">

            <?php
            include 'connexionBaseDeDonnees.php';

            $ids = afficherIds();
            foreach ($ids as $id) {

                echo '<div class="node-container" id="node' . $id . '">'; // Ajout d'un conteneur pour chaque nœud
                echo '<input type="checkbox" data-node-id="'.$id.'">' . $id;
                echo '</div>';
            }
            ?>

        </div>
    </div>

    <script src="rechercheParId.js" ></script>
    <div class="dropdown">
        <button class="dropbtn"> Affichage points
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="affPoints">
            <label><input type="checkbox" id="selectID"> ID</label>
            <label><input type="checkbox" id="selectUID"> UID</label>
        </div>
    </div>

    <div class="label">
        <b>Laboratory Map</b>
    </div>

    <!-- Futur boutons pour range nodes
    <div class="button">
        <button>Activer cercles</button>
        <button>Activer remplissage</button>
    </div>
    -->
</div>

<a href="debug.php">DEBUG</a>
<button id="unselectAll">Désélectionner tout</button>

<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Inclure le fichier JavaScript pour AJAX -->
<script src="scriptRecupererDonnes.js"></script>
<!-- Inclure le fichier JavaScript pour créer les points -->
<script src="scriptCreerPoint.js" ></script>
<!-- Inclure le fichier JavaScript pour les couches -->
<script src="scriptChangeLayers.js" ></script>
<!-- Inclure le script select all -->
<script src="scriptSelectAll.js"></script>

<img id="map-image" class="map-image">

<div id="map-container" class="map-container"></div>

<div id="map"></div>

<!-- Afficher la popup du noeud -->
<div id="popup" class="popup">
    <div id="popup-content" class="popup-content"></div>
</div>
</body>
</html>
