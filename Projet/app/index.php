<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <div class="navbar">
        <a href="#home">Home</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>

        <div class="dropdown">
            <button class="dropbtn"> Nods
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
                <label><input type="checkbox" name="info1"> Information 1</label>
                <label><input type="checkbox" name="info2"> Information 2</label>
                <label><input type="checkbox" name="info3"> Information 3</label>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn"> Layers
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <label><input type="checkbox" name="firstLayer"> First Layer </label>
                <label><input type="checkbox" name="secondLayer"> Second Layer </label>
                <label><input type="checkbox" name="thirdLayer"> Third Layer </label>
            </div>
        </div>
    </div>

    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Inclure le fichier JavaScript pour AJAX -->
    <script src="scriptRecupererDonnes.js"></script>
    <!-- Inclure le fichier JavaScript pour créer les points -->
    <script src="scriptCreerPoint.js" ></script>

    <img src="Images/map.png" class="map-image">
    
    <div id="map"></div>

    <!-- Ajoutez cette balise div à l'endroit où vous souhaitez afficher la boîte de dialogue -->
    <div id="popup" class="popup">
        <div id="popup-content" class="popup-content">
            <!-- Le contenu de la boîte de dialogue sera affiché ici -->
        </div>
    </div>
</body>
</html>