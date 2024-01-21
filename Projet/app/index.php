
<?php
?>
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
            <div class="dropdown-content">
                <label><input type="checkbox" name="Noeud1"> Noeud 1</label>
                <label><input type="checkbox" name="Noeud2"> Noeud 2</label>
                <label><input type="checkbox" name="Noeud3"> Noeud 3</label>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn"> Couches
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <label><input type="checkbox" name="firstLayer"> Couche 1 </label>
                <label><input type="checkbox" name="secondLayer"> Couche 2 </label>
                <label><input type="checkbox" name="thirdLayer"> Couche 3 </label>
            </div>
        </div>
    </div>

    <a href="debug.php">DEBUG</a>
    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Temp -->
    <script src="scriptRecupererDonnes.js"></script>
    <script src="scriptCreerPoint.js" ></script>

    <img src="Images/map.png" class="map-image">
    
    <div id="map"></div>
    <div id="popup"></div>
    <div id="popup-content"></div>
</body>
</html>
