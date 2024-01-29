<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenu des bases</title>
    <link rel="stylesheet" type="text/css" href="../Styles/debugStyle.css">
</head>

<body>

    <header>
        <a href="index.php"><button>Retourner à l'accueil</button></a>
        <h1>Bases de données</h1>
    </header>
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
