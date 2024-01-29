<?php
const servername = "BaseDeDonnes"; 
const username = "UserBd"; 
const password = "MotDePasseBD";
const dbname = "Donnes";

/**
 * Crée la connexion à la base de données et la retourne
 * @return mysqli La connexion à la base de données
 */
function CreerConnection()
{
    $conn = new mysqli(servername, username, password, dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

