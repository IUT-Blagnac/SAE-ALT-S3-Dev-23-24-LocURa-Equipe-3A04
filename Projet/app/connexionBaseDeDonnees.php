<?php
//On se connecte a la base de données mariaDB
const servername = "BaseDeDonnes"; 
const username = "UserBd"; 
const password = "MotDePasseBD";
const dbname = "Donnes";
const NomTableDonneesSetup = "DonneesCapteurs";   
const NomTableDonnesOut = "CommCapteurs";
const NomTableDonnesRanging = "RangingCapteurs";

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
    $requete = "DROP TABLE IF EXISTS ".NomTableDonnesRanging.",".NomTableDonnesOut. ",".NomTableDonneesSetup.";";
    $conn->execute_query($requete);
    
    
    $requete = "CREATE TABLE ".NomTableDonneesSetup." (
        idCapteur VARCHAR(30) PRIMARY KEY,
        x DECIMAL(5,3) NOT NULL,
        y DECIMAL(5,3) NOT NULL,
        z DECIMAL(5,3) NOT NULL,
        orientation DECIMAL(4,1) NOT NULL,
        color CHAR(6) NULL,
        UID CHAR(4) NULL,
        iddwm VARCHAR(30) NULL
    );";
    $conn ->execute_query($requete);

    $requete = "CREATE TABLE ".NomTableDonnesOut." (
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

    $creationTableRanging = "CREATE TABLE ".NomTableDonnesRanging. " (
        initiator VARCHAR(50),
        target VARCHAR(50),
        timestamp DECIMAL,
        `range` FLOAT,
        rangingError FLOAT,
        CONSTRAINT pk_".NomTableDonnesRanging." PRIMARY KEY (initiator, target, timestamp),
        CONSTRAINT fk_".NomTableDonnesRanging."_initiator FOREIGN KEY (initiator) REFERENCES ".NomTableDonneesSetup." (idCapteur),
        CONSTRAINT fk_".NomTableDonnesRanging."_target FOREIGN KEY (target) REFERENCES ".NomTableDonneesSetup." (idCapteur)
    );";
    $conn ->execute_query($creationTableRanging);

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
    if(str_contains($idCapteur,"dwm1001-")) //Les dwm rajoutent des infos
    {
        $uid = isset($data["UID"]) ? $data["UID"] : null;
        TraitementDWM($idCapteur,$x,$y,$z,$uid);
    }
    else //Les non dwm mettent les infos d'abord
    {
        $orientation = $data["orientation"];
        $color = $data["color"];
        $requete = "INSERT INTO ".NomTableDonneesSetup." (idCapteur, x, y, z, orientation, color) VALUES (?, ?, ?, ?, ?, ?)";

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

    
    
}

/**
 * Fonction qui traite des les capteurs dwm
 * @param string $idDWM L'id du DWM
 * @param float $x La position x du capteur
 * @param float $y La position y du capteur
 * @param float $z La position z du capteur
 * @param string $UID L'UID du capteur
 */
function TraitementDWM($idDWM, $x,$y,$z,$UID)
{
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $requete = "SELECT idCapteur FROM ".NomTableDonneesSetup." WHERE x = ? AND y = ? AND z = ? ";

    $statement = $conn->prepare($requete);


    if ($statement) {
        // Liez les paramètres à la requête
        $statement->bind_param("ddd", $x, $y, $z);
    
        // Exécutez la requête
        $statement->execute();
    
        // Récupérez le résultat
        $result = $statement->get_result();
    
        // Vérifiez s'il y a des résultats
        if ($result->num_rows ==1) {
            // Récupérez la première ligne
            $row = $result->fetch_assoc();
            $idCapteur = $row['idCapteur'];

            $idDWM = explode("-",$idDWM)[1];
    
            $requete = "UPDATE ".NomTableDonneesSetup." SET iddwm = ?, UID= ? WHERE idCapteur = ?";

            $statement = $conn->prepare($requete);
            $statement->bind_param("sss", $idDWM, $UID, $idCapteur);

            $statement->execute();


        }
    
        // Fermez le statement
        $statement->close();
        $conn->close();
    } else {
        // La préparation de la requête a échoué
        echo "Erreur lors de la préparation de la requête.";
    }

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
    
    $requete = "UPDATE ".NomTableDonneesSetup." SET x = ?, y=?, z=?, orientation=?, color=?,UID=? WHERE idCapteur=?";

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
    
    $requete = "SELECT * FROM ".NomTableDonneesSetup;
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
            'UID' => $row['UID'],
            'iddwm' => $row['iddwm']
        );
    }
    $conn->close();
    return $data;      
}

/**
 * Fonction qui récupère les ids des capteurs dans la base de données et les retourne sous forme de tableau
 */
function afficherIds()
{
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Vous pouvez maintenant exécuter vos requêtes SQL ici

    $requete = "SELECT idCapteur FROM ".NomTableDonneesSetup; // Modifier la requête pour récupérer seulement l'ID
    $resultat = $conn->query($requete);

    // Vérifier si la requête a réussi
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }

    $ids = array();

    while ($row = $resultat->fetch_assoc()) {
        $ids[] = $row['idCapteur'];
    }
    $conn->close();

    return $ids;
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

    $sql = "INSERT INTO ".NomTableDonnesOut." (node_id, timestamp, initiator, target, protocol, tof, range, rssiRequest, rssiData, temperature) VALUES ('?', '?', '?', '?', '?', '?', '?', '?', '?', '?')";

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
    
    $requete = "SELECT * FROM ".NomTableDonneesSetup;
    $resultat = $conn->query($requete);
    // Vérifier si la requête a réussi
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }

    $data = array();

    // Parcourir les résultats de la requête
    while ($row = $resultat->fetch_assoc()) {

        $requete = "SELECT * FROM ".NomTableDonnesOut." WHERE target = '".$row['idCapteur']."' ORDER BY timestmp DESC LIMIT 1";
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

#region Ranging 

function EnvoyerDonneesRanging($topic,$message)
{
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    $data = json_decode($message,true);
    $initiator = $data['initiator'];
    $target = $data['target'];
    $timestamp = $data['timestamp'];
    $range = $data['range'];
    $rangingError = $data['rangingError'];
    
    $requete = "INSERT INTO ".NomTableDonnesRanging." (initiator,target,timestamp,'range',rangingError) VALUES (?, ?, ?, ?, ?)";

    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param("ssdff", $initiator, $target, $timestamp, $range, $rangingError);

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
function RecupererDonneesRanging()
{    
    $conn = new mysqli(servername, username, password, dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    
    // Vous pouvez maintenant exécuter vos requêtes SQL ici
    
    $requete = "SELECT * FROM ".NomTableDonnesRanging;
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
            'initiator' => $row['initiator'],
            'target' => $row['target'],
            'timestamp' => $row['timestamp'],
            'range' => $row['range'],
            'rangingError' => $row['rangingError']
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
    
    $requete = "SELECT * FROM ".NomTableDonneesSetup;
    $resultat = $conn->query($requete);
    // Vérifier si la requête a réussi
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }
    //Création du tableau 
    echo "<table border='1' style='text-align: center;border-collapse: collapse; width: 60%;'>";
    echo "<tr><th>idCapteur</th><th>X</th><th>Y</th><th>Z</th><th>Orientation</th><th>Couleur</th><th>UID</th><th>DWM</th></tr>";
    // Afficher les résultats
    while ($row = $resultat->fetch_assoc()) {

        if($row['color'] == null){

            $color = "null";

        }else{
                
                $color = $row['color'];
    
        }
        
        if($row['UID'] == null){

            $UID = "null";

        }else{
                
                $UID = $row['UID'];
    
        }

        echo "<tr><td>" . $row['idCapteur'] . "</td><td>".  $row["x"] . "</td><td>". $row["y"] ."</td><td> ". $row["z"] . "</td><td>" . $row["orientation"] . " ° </td><td>". $color . "</td><td>". $UID."</td><td>".$row['iddwm']."</td></tr>" ;
    }
    echo "</table>";

    echo "<h2>Ranging : </h2><br>";
    $requete = "SELECT * FROM ".NomTableDonnesRanging;
    $resultat = $conn->query($requete);
    // Vérifier si la requête a réussi
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }
    echo "<table border='1' style='text-align: center;border-collapse: collapse; width: 60%;'>";
    echo "<tr><th>initiator</th><th>target</th><th>timestamp</th><th>range</th><th>rangingError</th></tr>";
    while ($row = $resultat->fetch_assoc()) {
        echo "<tr><td>" . $row['initiator'] . "</td><td>".  $row["target"] . "</td><td>". $row["timestamp"] ."</td><td> ". $row["range"] . "</td><td>" . $row["rangingError"] . "</td></tr>" ;
    }
    echo "</table>";

    $conn->close();
}

/**
 * Fonction qui vérifie si la table capteurs existe
 */
function verifier_tablecapteurs(){
        $conn = new mysqli(servername, username, password, dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }
        
        $requete = "SELECT COUNT(*) FROM ".NomTableDonnesOut;
        
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

/**
 * Fonction de gogole a enlever
 */
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

    $requete = "INSERT INTO ".NomTableDonneesSetup." (idCapteur, x, y, z, orientation, color,UID) VALUES (?, ?, ?, ?, ?, ?,?)";

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