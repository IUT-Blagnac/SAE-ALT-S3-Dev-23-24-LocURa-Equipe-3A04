<?php

include("connexionBaseDeDonnees.php");

afficherDonnees();
if(verifier_tablecapteurs()){
    echo "La table Capteurs existe";
}
else{
    echo "La table n'existe pas";
}
recupererDonneesCapteurs();
