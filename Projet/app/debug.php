<?php

session_start();

if(isset($_SESSION["DonneesSetup"])){
    print_r($_SESSION["DonneesSetup"]);
}
else{
    echo "Pas de données";
}

