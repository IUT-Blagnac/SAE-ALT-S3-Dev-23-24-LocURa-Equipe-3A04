<?php
require_once("connexionBaseDeDonnees.php");

if(isset($_POST["request"]))
{
    if($_POST["request"] == "pointsFixesData")
    {
        header('Content-Type: application/json');
        echo json_encode(RecupererDonneesSetup());
    }
}