<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenu des bases</title>
    <link rel="stylesheet" type="text/css" href="../Styles/debugStyle.css">
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
<body>
	
    <header>
        <div><a href="../index.php"><button>Retourner à l'accueil</button></a></div>
        <div><h1>Bases de données</h1></div>
        <div id="mqtt_spinner" class="spinner-grow text-danger" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </header>
    
     <!-- Inclure le script pour le status MQTT -->
     <script type="module" src="../ScriptsAjax/scriptStatusMQTT.js"></script>
    <center>
    <main>
        <?php
        include("../BaseDeDonnees/connexionBaseDeDonnees.php");
        afficherDonnees();
        
        ?>
    </main>
    </center>

</body>

</html>
