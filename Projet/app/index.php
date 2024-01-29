<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Styles/style.css">
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

            require_once 'BaseDeDonnees/connexionBaseDeDonnees.php';



            try {
                $ids = afficherIds();
                foreach ($ids as $id) {

                    echo '<div class="node-container" id="node' . $id . '">'; // Ajout d'un conteneur pour chaque nœud
                    if(isset($id['UID']) && isset($id['iddwm']))
                        echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'] ." - " . $id['UID'] ." - "  . $id['iddwm'];
                    else if(isset($id['UID']))
                        echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'] ." - " . $id['UID'];
                    else if(isset($id['iddwm']))
                        echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'] ." - "  . $id['iddwm'];
                    else
                        echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'];
                    
                    echo '</div>';
                }
            }catch (Exception $e){
                echo "Aucune donné dans la table";
            }

            
            ?>

        </div>
    </div>

    <div class="dropdown"><button class="dropbtn"><a href="Pages/debug.php">DEBUG</a></button></div>
    

    <div class="dropdown">

        <button class="dropbtn"> Affichage selon IDs
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="affPoints">
            <label><input type="checkbox" id="selectID" > ID</label>
            <label><input type="checkbox" id="selectUID"> UID</label>
            <label><input type="checkbox" id="selectDWM"> DWM</label>
        </div>
    </div>

    <div class="label">
        <b>Laboratory Map</b>
    </div>

    <!-- Range nodes -->
    <div class="button">
        <button>Activer cercles</button>
        <button class="hidden">Activer Remplissage</button>
        <button>Activer ligne</button>
    </div>
    <div id="mqtt_spinner" class="spinner-grow text-danger" role="status">
    <span class="sr-only">Loading...</span>
    </div>



</div>

<button id="unselectAll">Désélectionner tout</button>




<!-- Inclure jQuery -->
<script type="module" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Inclure le fichier JavaScript pour les couches -->
<script src="DiversJavaScripts/scriptChangeLayers.js" ></script>

<!-- Script qui permet de gérer la recherche par id des noeuds -->
<script src="DiversJavaScripts/rechercheParId.js" ></script>

<!-- Fichiers JavaScript et AJAX pour récupération de données -->
<script type="module" src="ScriptsAjax/scriptRecupererDonneesSetup.js"></script>
<script type="module" src="ScriptsAjax/scriptRecupererDonneesRanging.js"></script>
<script type ="module" src = "ScriptsAjax/scriptRecupererDonneesMobile.js"></script>
<script type="module" src ="ScriptsAjax/scriptClignoterPoints.js"></script>
<script type="module" src="ScriptsAjax/scriptStatusMQTT.js"></script>

<!-- Inclure le fichier JavaScript pour créer les points -->
<script type="module" src="ScriptsCreationElements/scriptCreerPoint.js" ></script>

<img id="map-image" class="map-image">

<!-- Ligne du noeud mobile -->
<div class="ligneMobile" id="ligneMobile"></div>
<script type="module" src="ScriptsCreationElements/scriptCreerLigneMobile.js" ></script>

<div id="map-container" class="map-container"></div>

<div id="map"></div>

<div id="popup" class="popup">
    <div id="popup-content" class="popup-content"></div>
</div>
</body>
</html>
