<?php
//On se connecte a la base de données mariaDB
const servername = "BaseDeDonnes"; 
const username = "UserBd"; 
const password = "MotDePasseBD";
const dbname = "Donnes";
const table_name = "DonneesCapteurs";   

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
    
    $requete = "CREATE TABLE IF NOT EXISTS ".table_name." (
        idCapteur VARCHAR(30) PRIMARY KEY,
        x DECIMAL(5,3) NOT NULL,
        y DECIMAL(5,3) NOT NULL,
        z DECIMAL(5,3) NOT NULL,
        orientation DECIMAL(4,1) NOT NULL,
        color CHAR(6) NULL
    );";
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

    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    $data = json_decode($message,true);
    $idCapteur = explode("/",$topic)[1];
    $x = $data["x"];
    $y = $data["y"];
    $z = $data["z"];
    $orientation = $data["orientation"];
    $color = $data["color"];
    
    $requete = "INSERT INTO ".table_name." (idCapteur, x, y, z, orientation, color) VALUES (?, ?, ?, ?, ?, ?)";

    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param("sdddds", $idCapteur, $x, $y, $z, $orientation, $color);

    // Exécution de la requête
    $resultat = $statement->execute();

    // Vérifier l'exécution de la requête
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $statement->error);
    }

    // Fermer la connexion et le statement
    $statement->close();
    $conn->close();
}

/**
 * Fonction qui selectionne toutes les données et les dump dans un echo
 * Pour debug uniquement
 */
function afficherDonnees()
{
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    
    // Vous pouvez maintenant exécuter vos requêtes SQL ici
    
    $requete = "SELECT * FROM ".table_name;
    $resultat = $conn->query($requete);
    // Vérifier si la requête a réussi
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }
    // Afficher les résultats
    while ($row = $resultat->fetch_assoc()) {
        echo $row["idCapteur"] . " id , ". $row["x"] . " x , ". $row["y"] ." y , ". $row["z"] . "z , " . $row["orientation"] . " ° , ". $row["color"] . "couleur <br>" ;
    }
    $conn->close();
}

function recupererDonneesCapteurs()
{
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    
    // Vous pouvez maintenant exécuter vos requêtes SQL ici
    
    $requete = "SELECT * FROM ".table_name;
    $resultat = $conn->query($requete);
    // Vérifier si la requête a réussi
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }
    $data = array();

    // Parcourir les résultats de la requête
    while ($row = $resultat->fetch_assoc()) {
        // Ajouter chaque ligne au tableau
        $data[] = array(
            'idCapteur' => $row['idCapteur'],
            'x' => $row['x'],
            'y' => $row['y'],
            'z' => $row['z'],
            'orientation' => $row['orientation'],
            'color' => $row['color']
        );
    }
    $conn->close();
    return $data;    
}

?>