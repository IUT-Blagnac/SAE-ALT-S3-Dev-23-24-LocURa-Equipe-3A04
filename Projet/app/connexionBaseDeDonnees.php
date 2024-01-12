<?php
//On se connecte a la base de données mariaDB
const servername = "BaseDeDonnes"; 
const username = "UserBd"; 
const password = "MotDePasseBD";
const dbname = "Donnes";   

/**
 * Fonction qui intialise la base de données en créant les tables si elle n'existent pas
 */
function InitBase()
{
    

    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    
    // Vous pouvez maintenant exécuter vos requêtes SQL ici
    
    $table_name = "DonneesCapteurs";
    $requete = "CREATE TABLE IF NOT EXISTS $table_name (
        idCapteur VARCHAR(30) PRIMARY KEY,
        x DECIMAL(5,3) NOT NULL,
        y DECIMAL(5,3) NOT NULL,
        z DECIMAL(5,3) NOT NULL,
        orientation DECIMAL(4,1) NOT NULL,
        color CHAR(6) NULL
    )";
    $conn ->execute_query($requete);
    $conn->close();
}

/**
 * Fonction qui envoie les données reçues du noeud dans la base de données
 * La fonction parse les données reçues sous format json
 * @param string $topic Le topic du message
 * @param string $message Le message reçu sous format json
 */

function EnvoyerDonnesNoeud($topic,$message)
{

    $table_name = "DonneesCapteurs";

    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    $data = json_decode($message);
    $idCapteur = $topic; // Assuming the topic is the sensor ID
    $x = $data['x'];
    $y = $data['y'];
    $z = $data['z'];
    $orientation = $data['orientation'];
    $color = $data['color'];
    // Vous pouvez maintenant exécuter vos requêtes SQL ici
    
    $table_name = "DonneesCapteurs";
    $requete = "INSERT INTO $table_name (
        idCapteur,
        x,
        y,
        z,
        orientation,
        color
    )
    VALUES (
        $idCapteur,
        $x,
        $y,
        $z,
        $orientation,
        $color
    )";
    $conn ->execute_query($requete);
    $conn->close();
}
?>