<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Styles/style.css">
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
            <label><input type="checkbox" class="select-all" id="selectAll">Select All</label>
            <label><input type="checkbox" name="premierEtage" id="premierEtage" checked> Etage 1 </label>
            <label><input type="checkbox" name="deuxiemeEtage" id="deuxiemeEtage"> Etage 2 </label>
            <label><input type="checkbox" name="troisiemeEtage" id="troisiemeEtage"> Etage 3 </label>
        </div>
    </div>
    <!-- <div id="status-icon" class="status-icon" <?php //require('./connexionMQTT.php');
    //echo $isConnected ? 'green-blink' : 'red'; ?>> -->
    <div class="dropdown">
        <button class="dropbtn"> Noeuds
            <i class="fa fa-caret-down"></i>
        </button>
        <input type="text" id="searchInput" onkeyup="filterNodes()" placeholder="Rechercher par ID..."><br>

        <div class="dropdown-content" id="nodes">

            <?php
            
            require_once 'BaseDeDonnees/connexionBaseDeDonnees.php';



            $ids = afficherIds();

            foreach ($ids as $id) {
                
                echo '<div class="node-container" id="node' . $id . '">'; // Ajout d'un conteneur pour chaque nœud
                if($id['UID'] != null && $id['iddwm'] != null)
                    echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'] ." - " . $id['UID'] ." - "  . $id['iddwm'];
                else if($id['UID'] != null)
                    echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'] ." - " . $id['UID'];
                else if($id['iddwm'] != null)
                    echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'] ." - "  . $id['iddwm'];
                else
                    echo '<input type="checkbox" data-node-id="'.$id['idCapteur'].'">' . $id['idCapteur'];
                
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="DiversJavaScripts/rechercheParId.js" ></script>
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
        Laboratory Map
    </div>

     <!-- Futur boutons pour range nodes -->
    <div class="button">
        <button>Activer cercles</button>
        <button class="hidden">Activer Remplissage</button>
        <button>Activer ligne</button>
    </div>
    
</div>
<a href="Pages/debug.php">DEBUG</a>
<!-- jQuery -->
<script type="module" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Fichiers JavaScript pour récupération de données -->
<script type="module" src="ScriptsAjax/scriptRecupererDonneesSetup.js"></script>
<script type="module" src="ScriptsAjax/scriptRecupererDonneesRanging.js"></script>
<script type ="module" src = "ScriptsAjax/scriptRecupererDonneesMobile.js"  ></script>

<!-- Inclure le fichier JavaScript pour créer les points -->
<script type="module" src="ScriptsCreationElements/scriptCreerPoint.js" ></script>
<!-- Inclure le fichier JavaScript pour les couches -->
<script src="ScriptsAjax/ajaxRequestToDataPHP.js" ></script>


<img id="map-image" class="map-image">

<div id="map-container" class="map-container"></div>

<div id="map"></div>

<div id="popup" class="popup">
    <div id="popup-content" class="popup-content"></div>
</div>
</body>
</html>
