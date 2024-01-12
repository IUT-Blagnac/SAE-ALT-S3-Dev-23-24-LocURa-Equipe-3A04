<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="navbar">
    <a href="https://www.irit.fr/plateformes/plateforme-locura4iot/">Informations</a>
    <div class="dropdown">
        <button class="dropbtn"> Noeuds
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <label><input type="checkbox" name="info1"> Noeud 1</label>
            <label><input type="checkbox" name="info2"> Noeud 2</label>
            <label><input type="checkbox" name="info3"> Noeud 3</label>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn"> Couches
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <label><input type="checkbox" name="firstLayer"> Première couche </label>
            <label><input type="checkbox" name="secondLayer"> Deuxième couche </label>
            <label><input type="checkbox" name="thirdLayer"> Troisième couche </label>
        </div>
    </div>

</div>

<img src="Images/map.png" class="map-image">

</body>
</html>