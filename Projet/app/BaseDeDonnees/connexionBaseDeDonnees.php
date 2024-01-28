<?php
const NomTableDonneesSetup = "DonneesCapteurs";   
const NomTableDonnesOut = "CommCapteurs";
const NomTableDonnesRanging = "RangingCapteurs";
const NomTableDonnesMobile = "MobileCapteurs";

const nbLignesMobile = 10;

require_once('creationConnexionBD.php');

#region Intialisation de la base de données
/**
 * Fonction qui intialise la base de données en créant les tables si elle n'existent pas
 */
function InitBase()
{
    $conn = CreerConnection();
    // Vous pouvez maintenant exécuter vos requêtes SQL ici
    $requete = "DROP TABLE IF EXISTS ".NomTableDonnesRanging.",".NomTableDonnesOut. ",".NomTableDonneesSetup.",".NomTableDonnesMobile.";";
    $conn->execute_query($requete);
    
    
    $requete = "CREATE TABLE ".NomTableDonneesSetup." (
        idCapteur VARCHAR(30) NULL,
        iddwm VARCHAR(30) NULL,
        x DECIMAL(5,3) NOT NULL,
        y DECIMAL(5,3) NOT NULL,
        z DECIMAL(5,3) NOT NULL,
        orientation DECIMAL(4,1) NOT NULL,
        color CHAR(6) NULL,
        CONSTRAINT PK_Setup PRIMARY KEY (x,y,z)
    );";
    //CETTE TABLE EST MODIFIEE DYNAMIQUEMENT EN FONCTION DES DONNEES REÇUES, IL EST INUTILE DE CHANGER LA REQUETE SAUF POUR DES DONNEES IMPORTANTES

    $conn ->execute_query($requete);

    $requete = "CREATE TABLE ".NomTableDonnesOut." (
        id INT AUTO_INCREMENT PRIMARY KEY,
        node_id VARCHAR(50) NOT NULL,
        timestamp TIMESTAMP default current_timestamp,
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
    
    $requeteCMOBILE = "CREATE TABLE ".NomTableDonnesMobile." (
        id INT AUTO_INCREMENT PRIMARY KEY,
        idCapteur VARCHAR(30) NOT NULL,
        timestamp TIMESTAMP default current_timestamp,
        x DECIMAL(5,3) NOT NULL,
        y DECIMAL(5,3) NOT NULL,
        z DECIMAL(5,3) NOT NULL,
        color CHAR(6),
        uid CHAR(4) 
    );";
    $conn ->execute_query($requeteCMOBILE);

    $creationTableRanging = "CREATE TABLE ".NomTableDonnesRanging. " (
        initiator VARCHAR(50) NOT NULL,
        target VARCHAR(50) NOT NULL,
        timestamp TIMESTAMP default current_timestamp,
        `range` FLOAT NOT NULL,
        rangingError FLOAT NOT NULL,
        CONSTRAINT PK_Ranging PRIMARY KEY (initiator, target)
    );";
    $conn ->execute_query($creationTableRanging);

    $conn->close();
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
    $conn = CreerConnection();
    
    $data = json_decode($message,true);
    $idCapteur = explode("/",$topic)[1];
    $iddwm = null;

    $colonnes = array_keys($data);

    ModifierTableSetup($colonnes);

    if(str_contains($idCapteur,"dwm1001-")) //Les dwm rajoutent des infos
    {
        $iddwm = explode("-",$idCapteur)[1];
    }

    //On genere la requete en fonction des colonnes du json

    $colonnes_string = implode(",",$colonnes);

    $interrogations = str_repeat('?,', count($colonnes));
    //On supprime la dernière virgule
    $interrogations = substr($interrogations,0,-1);

    $requete = "INSERT INTO ".NomTableDonneesSetup." (".$colonnes_string.",idCapteur) VALUES (".$interrogations.",?)
    ON DUPLICATE KEY UPDATE
    iddwm =".(isset($iddwm) ? $iddwm : "null").
    (isset($data['UID']) ? ", UID = '".$data['UID']."';" : ";");

    // Préparation de la requête
    $statement = $conn->prepare($requete);
    
    $types = str_repeat('s', count($data)+1);
    $parameters = array(&$types); //On met les types en premier dans le tableau

    foreach ($data as $key => $value) {
        ${$key} = $value; //On crée une variable avec le nom de la colonne -> Permet de récupérer une référence à la variable
        $parameters[] = &${$key};
    }
    
    $parameters[] = &$idCapteur;

    // Fonction magique qui permet de lier les paramètres à la requête
    // Cette fonction a besoin d'un tableau de références de variables
    call_user_func_array(array($statement, 'bind_param'), $parameters);

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
 * Fonction qui ajoute des colonnes à la table DonneesSetup si elles sont nécessaires
 * @param array $nomColonnnes Tableau contenant les colonnes du json
 */
function ModifierTableSetup($nomColonnnes)
{
    $conn = CreerConnection();
    
    
    $requete= "DESCRIBE ".NomTableDonneesSetup;
    $resultat = $conn->execute_query($requete);

    $colonnes = array();
    while($row = $resultat->fetch_assoc())
    {
        $colonnes[] = $row['Field'];
    }
    
    //On compare les colonnes de la table avec les colonnes du json
    foreach($nomColonnnes as $nomColonne)
    {
        if(!in_array($nomColonne,$colonnes))
        {
            $requete = "ALTER TABLE ".NomTableDonneesSetup." ADD ".$nomColonne." VARCHAR(50) NULL";
            $resultat = $conn->query($requete);
        }
    }
    $conn->close();
}

/**
 * Fonction qui récupère les données de la base de données et les retourne sous forme de tableau
 * @return array $data Tableau contenant les données
 */
function RecupererDonneesSetup()
{  
    $conn = CreerConnection();
      
    
    $requete = "SELECT * FROM ".NomTableDonneesSetup;
    $resultat = $conn->query($requete);

    $data = array();

    while ($row = $resultat->fetch_assoc()) {
        $data[] = $row;
    }
    $conn->close();
    return $data;      
}

/**
 * Fonction qui récupère les ids des capteurs dans la base de données et les retourne sous forme de tableau
 */
function afficherIds()
{
    $conn = CreerConnection();
    

    $requete = "SELECT idCapteur,UID,iddwm FROM ".NomTableDonneesSetup; // Modifier la requête pour récupérer seulement l'ID

    $resultat = $conn->query($requete);
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }

    $ids = array();

    while ($row = $resultat->fetch_assoc()) {
        $ids[] = $row;
    }

    //On rajoute les id des noeuds mobiles
    $requete = "SELECT idCapteur,UID FROM ".NomTableDonnesMobile;



    $conn->close();

    return $ids;
}



#endregion

#region Fonctions DonneesMobile

/**
 * Fonction qui envoie les données du noeud mobile dans la base de données
 */
function EnvoyerDonneesNoeudMobile($topic,$message){
    $conn = CreerConnection();
    

    $data = json_decode($message,true);
    $idCapteur = explode("/",$topic)[1];
    $x = $data["x"];
    $y = $data["y"];
    $z = $data["z"];
    $color = $data["color"];
    $uid = $data["UID"];

    $requete = "INSERT INTO ".NomTableDonnesMobile." (idCapteur, x, y, z, color, uid) VALUES (?, ?, ?, ?, ?, ?)";

    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param("sdddss", $idCapteur, $x, $y, $z, $color, $uid);

    // Exécution de la requête
    $resultat = $statement->execute();

    // Vérifier l'exécution de la requête
    if($resultat === false){
        die("Erreur d'exécution de la requête : " . $statement->error);
    }

    // Fermer la connexion et le statement
    $statement->close();
    $conn->close();

    GestionNbLignesMobile();
}

/**
 * Fonction qui récupère les données la position du point mobile
 * @return array $data Tableau contenant les données
 */
function RecupererDonneesMobile(){

    $conn = CreerConnection();
    

    $requete = "SELECT * FROM ".NomTableDonnesMobile." WHERE timestamp = (SELECT MAX(timestamp) FROM ".NomTableDonnesMobile.")";

    $resultat = $conn->query($requete);
    
    //Vérifier si la requête a réussi
    if($resultat === false){
        die("Erreur d'exécution de la requête : " . $conn->error);
    }

    $data = array();

    //Parcourir les résultats de la requête
    while($row = $resultat->fetch_assoc()){
        //Ajouter chaque ligne au tableau
        $data[] = array(
            'idCapteur' => $row['idCapteur'],
            'x' => $row['x'],
            'y' => $row['y'],
            'z' => $row['z'],
            'color' => $row['color'],
            'UID' => $row['uid']
        );
    }
    $conn->close();
    return $data;
}

/**
 * Permet de gérer le nombre de lignes dans la table DonneesMobile
 * Si il y a plus de nbLignesMobile lignes dans la table, on supprime la ligne la plus ancienne
 */
function GestionNbLignesMobile()
{
    $conn = CreerConnection();
    

    $requete = "SELECT COUNT(*) FROM ".NomTableDonnesMobile;

    $resultat = $conn->query($requete);
    
    //Vérifier si la requête a réussi
    if($resultat === false){
        die("Erreur d'exécution de la requête : " . $conn->error);
    }

    $row = $resultat->fetch_assoc();

    //Si plus de nbLignesMobiles lignes dans la table, on supprime la première ligne en fonction de son timestamp
    if($row['COUNT(*)'] > nbLignesMobile)
    {
        $requete = "DELETE FROM ".NomTableDonnesMobile." ORDER BY timestamp LIMIT 1";
        $resultat = $conn->query($requete);
    }
    $conn->close();
}


/**
 * Fonction qui traite des les capteurs dwm
 * @param string $idDWM L'id du DWM
 * @param float $x La position x du capteur
 * @param float $y La position y du capteur
 * @param float $z La position z du capteur
 * @param string $UID L'UID du capteur
 */
function TraitementDWMMobile($idDWM, $x,$y,$z,$UID)
{
    $conn = CreerConnection();
    

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

#endregion

#region Fonctions DonneesComm
function envoyerDonneesComm($topic,$message){
    $conn = CreerConnection();
    

    $donneespayld = json_decode($message, true);
    $timestamp = $donneespayld['timestamp'];
    $node_id = $donneespayld['node_id'];
    $donnesexplicit = json_decode($donneespayld['payload'], true);
    if(isset($donnesexplicit))
    {
        $initiator = $donnesexplicit['initiator'];
        $target = $donnesexplicit['target'];
        $protocol = $donnesexplicit['protocol'];
        $tof = $donnesexplicit['tof'];
        $range = $donnesexplicit['range'];
        $rssiRequest = $donnesexplicit['rssiRequest'];
        $rssiData = $donnesexplicit['rssiData'];
        $temperature = $donnesexplicit['temperature'];
    }
    else 
    {
        $initiator = null;
        $target = null;
        $protocol = null;
        $tof = null;
        $range = null;
        $rssiRequest = null;
        $rssiData = null;
        $temperature = null;
    }
    

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
    $conn = CreerConnection();
    
    
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

/**
 * Permet d'insérer les données de ranging dans la base de données
 * Ne stocke que les données les plus récentes en remplacant les anciennes
 */
function EnvoyerDonneesRanging($topic,$message)
{
    $conn = CreerConnection();
    

    $data = json_decode($message,true);
    $initiator = $data['initiator'];
    $target = $data['target'];
    $range = $data['range'];
    $rangingError = $data['rangingError'];

    $requete = "
    INSERT INTO `" . NomTableDonnesRanging . "` (`initiator`, `target`, `range`, `rangingError`)
        VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        `range` = ?,
        `rangingError` = ?,
        `timestamp` = CURRENT_TIMESTAMP";


    // Préparation de la requête
    $statement = $conn->prepare($requete);

    $statement->bind_param('ssdddd', $initiator, $target, $range, $rangingError, $range, $rangingError);


    // Exécution de la requête
    $resultat = $statement->execute();

    // Vérifier l'exécution de la requête
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $statement->error);
    }
    $statement->close();

    $conn->close();
}


/**
 * Fonction qui récupère les données de la base de données et les retourne sous forme de tableau
 * @return array $data Tableau contenant les données
 */
function RecupererDonneesRanging()
{    
    $conn = CreerConnection();
    
    
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
 * Fonction qui selectionne toutes les données des bases et les affiche dans des tableaux
 * Pour debug uniquement
 */
function afficherDonnees()
{
    AfficherDonneesTable(NomTableDonneesSetup);
    AfficherDonneesTable(NomTableDonnesOut);
    AfficherDonneesTable(NomTableDonnesRanging);
    AfficherDonneesTable(NomTableDonnesMobile);
}

/**
 * Fonction qui affiche les données de n'importe quelle table sous forme de tableau
 */
function AfficherDonneesTable($nomTable)
{
    $conn = CreerConnection();
    
    
    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $requete = "DESCRIBE ".$nomTable;
    $resultat = $conn->query($requete);
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }
    $colonnes = array();
    while($row = $resultat->fetch_assoc())
    {
        $colonnes[] = $row['Field'];
    }
    $resultat->close();

    $requete = "SELECT * FROM ".$nomTable;
    $resultat = $conn->query($requete);
    if ($resultat === false) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }


    echo "<h2>".$nomTable.": </h2><br>";

    //Création du tableau 
    echo "<table class='table-debug'>";
    //On genere les entetes du tableau
    echo "<tr>";
    foreach($colonnes as $colonne)
    {
        echo "<th>".$colonne."</th>";
    }
    echo "</tr>";
    // Afficher les résultats
    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>";
        foreach($colonnes as $colonne)
        {
            if($row[$colonne] == null) //Si la valeur est null, on affiche null
                echo "<td>null</td>";
            else
                echo "<td>".$row[$colonne]."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

    $conn->close();
}

#endregion