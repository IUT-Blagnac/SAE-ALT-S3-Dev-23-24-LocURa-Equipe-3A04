<?php
//On se connecte a la base de données mariaDB
const servername = "BaseDeDonnes"; 
const username = "UserBd"; 
const password = "MotDePasseBD";
const dbname = "Donnes";
const table_name = "DonneesCapteurs";   
const table_name2 = "CommCapteurs";

#region Intialisation de la base de données
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
    
    $requete = "CREATE OR REPLACE TABLE ".table_name." (
        idCapteur VARCHAR(30) PRIMARY KEY,
        x DECIMAL(5,3) NOT NULL,
        y DECIMAL(5,3) NOT NULL,
        z DECIMAL(5,3) NOT NULL,
        orientation DECIMAL(4,1) NOT NULL,
        color CHAR(6) NULL,
        UID VARCHAR(30) NULL,
        iddwm VARCHAR(30) NULL
    );";
    

    $conn ->execute_query($requete);

    $requete = "CREATE OR REPLACE TABLE ".table_name2." (
        id INT AUTO_INCREMENT PRIMARY KEY,
        node_id VARCHAR(50) NOT NULL,
        timestmp DOUBLE NOT NULL,
        initiator VARCHAR(50),
        target VARCHAR(50),
        protocol VARCHAR(50),
        tof FLOAT,
        `range` FLOAT,
        rssiRequest FLOAT,
        rssiData FLOAT,
        temperature FLOAT
    );";
    $conn ->execute_query($requete);
    $conn->close();

    AjouterPointOrigine();
}

#endregion


#region Fonctions DonneesSetup
/**
 * Fonction qui envoie les données reçues du noeud dans la base de données
 * La fonction parse les données reçues sous format json
 * @param string $topic Le topic du message
 * @param string $message Le message reçu sous format json
 */
function EnvoyerDonnesNoeudSetup($topic,$message)
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
    $uid = isset($data["UID"]) ? $data["UID"] : null;
    
    $requete = "INSERT INTO ".table_name." (idCapteur, x, y, z, orientation, color,UID) VALUES (?, ?, ?, ?, ?, ?,?)";

    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param("sddddss", $idCapteur, $x, $y, $z, $orientation, $color,$uid);

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
 * Update les données des noeuds dans la base de données
 * @param string $topic Le topic du message
 * @param string $message Le message reçu sous format json
 */
function UpdateDonneesNoeudSetup($topic,$message)
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
    $uid = isset($data["UID"]) ? $data["UID"] : null;
    
    $requete = "UPDATE ".table_name." SET x = ?, y=?, z=?, orientation=?, color=?,UID=? WHERE idCapteur=?";

    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param("dddsdss", $x, $y, $z, $orientation, $color, $uid, $idCapteur);

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
 * Fonction qui récupère les données de la base de données et les retourne sous forme de tableau
 * @return array $data Tableau contenant les données
 */
function RecupererDonneesSetup()
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
            'color' => $row['color'],
            'UID' => $row['UID']   
        );
    }
    $conn->close();
    return $data;      
}



#endregion

#region Fonctions DonneesComm
function envoyerDonneesComm($topic,$message){
    $conn = new mysqli(servername, username, password, dbname);

    if($conn->connect_error){
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    $donneespayld = json_decode($message, true);
    $timestamp = $donneespayld['timestamp'];
    $node_id = $donneespayld['node_id'];
    $donnesexplicit = json_decode($donneespayld['payload'], true);
    $initiator = $donnesexplicit['initiator'];
    $target = $donnesexplicit['target'];
    $protocol = $donnesexplicit['protocol'];
    $tof = $donnesexplicit['tof'];
    $range = $donnesexplicit['range'];
    $rssiRequest = $donnesexplicit['rssiRequest'];
    $rssiData = $donnesexplicit['rssiData'];
    $temperature = $donnesexplicit['temperature'];

    $sql = "INSERT INTO ".table_name2." (node_id, timestamp, initiator, target, protocol, tof, range, rssiRequest, rssiData, temperature) VALUES ('?', '?', '?', '?', '?', '?', '?', '?', '?', '?')";

    $statement = $conn->prepare($sql);
    $statement -> bind_param("sdsdddddd", $node_id, $timestamp, $initiator, $target, $protocol, $tof, $range, $rssiRequest, $rssiData, $temperature);
    
    $resultat = $statement->execute();

    if($resultat === false){
        die("Erreur d'exécution de la requête : " . $statement->error);
    }

    $statement->close();
    $conn->close();
}

/**
 * Fonction qui récupère les données de la base de données et les retourne sous forme de tableau
 * @return array $data Tableau contenant les données
 */
function RecupererDonneesComm()
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

        $requete = "SELECT * FROM ".table_name2." WHERE target = '".$row['idCapteur']."' ORDER BY timestmp DESC LIMIT 1";
        $resultat2 = $conn->query($requete);
        // Vérifier si la requête a réussi
        if ($resultat2 === false) {
            die("Erreur d'exécution de la requête : " . $conn->error);
        }

        $row2 = $resultat2->fetch_assoc();
        $data[] = array(
            'idCapteur' => $row['idCapteur'],
            'x' => $row['x'],
            'y' => $row['y'],
            'z' => $row['z'],
            'orientation' => $row['orientation'],
            'color' => $row['color'],
            'timestamp' => $row2['timestmp'],
            'initiator' => $row2['initiator'],
            'target' => $row2['target'],
            'protocol' => $row2['protocol'],
            'tof' => $row2['tof'],
            'range' => $row2['range'],
            'rssiRequest' => $row2['rssiRequest'],
            'rssiData' => $row2['rssiData'],
            'temperature' => $row2['temperature'],
            'UID' => $row['UID']   
        );
    }

    $conn->close();
    return $data;    
}



#endregion

#region Debug

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
        echo $row["idCapteur"] . " id , ". $row["x"] . " x , ". $row["y"] ." y , ". $row["z"] . "z , " . $row["orientation"] . " ° , ". $row["color"] . "couleur , ". $row['UID']."UID <br>" ;
    }
    $conn->close();
}

function verifier_tablecapteurs(){
        $conn = new mysqli(servername, username, password, dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }
        
        $requete = "SELECT COUNT(*) FROM ".table_name2;
        
        $resultat = $conn->query($requete);
        // Vérifier si la requête a réussi
        if ($resultat === false) {
            die("Erreur d'exécution de la requête : " . $conn->error);
        }
        
        // Récupérer le nombre de lignes
        $count = $resultat->fetch_row()[0];
        
        $conn->close();
        
        return $count == 0;
}

function AjouterPointOrigine() {
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $idCapteur = "CapteurOrigine";
    $x = 0;
    $y = 0;
    $z = 0;
    $orientation = 0;
    $color = "000000"; // noir en hexadécimal
    $uid = null;

    $requete = "INSERT INTO ".table_name." (idCapteur, x, y, z, orientation, color,UID) VALUES (?, ?, ?, ?, ?, ?,?)";

    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param("sddddss", $idCapteur, $x, $y, $z, $orientation, $color,$uid);

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

#endregion