<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Debug</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        a {
            color: #fff;
            text-decoration: none;
            margin-right: 1em;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        button {
            background-color: darkslategray; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            text-decoration: none;
        }

        h1 {
            text-align: center; 
            flex-grow: 0.9;
            margin: 0;
            position: center;
        }

        main {
            padding-top: 10px;
            padding-bottom: 70px;
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php"><button>Retourner à l'accueil</button></a>
        <h1>LocURa4IoT</h1>
    </header>
    <center>
    <main>
        <?php
        include("connexionBaseDeDonnees.php");
        afficherDonnees();
        
        if (verifier_tablecapteurs()) {
            echo " La table Capteurs existe <br>"; 
        } else {
            echo "La table Capteurs n'existe pas <br>";
        }
        ?>
    </main>
    </center>
    <footer>
        <h2 style="margin: 0px"> Groupe 4 SAE-DevApp-ALT</h2>
    </footer>

</body>

</html>
