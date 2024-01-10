<?php

// Exemple de données à renvoyer au format JSON
$donnees = [
    ["x" => 100, "y" => 200],
    ["x" => -50, "y" => 100]
];

// Envoyer les données au client au format JSON
header('Content-Type: application/json');
echo json_encode($donnees);
?>
