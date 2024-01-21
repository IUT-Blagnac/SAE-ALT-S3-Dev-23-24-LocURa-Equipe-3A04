
<?php

include("connexionBaseDeDonnees.php");
// phpinfo();
//echo "<a href='Page2.php'>Page 2</a>";

//echo "<br>";

// DEBUG
//echo "<a href='connexionMQTT.php'>PageDonnes</a>";

afficherDonnees();
if(verifier_tablecapteurs()){
    echo "La table Capteurs existe";
}
else{
    echo "La table n'existe pas";
}
recupererDonneesCapteurs();

?>

