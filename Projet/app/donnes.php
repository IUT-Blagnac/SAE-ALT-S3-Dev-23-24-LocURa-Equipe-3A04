<?php

// Exemple de données à renvoyer au format JSON
$donnees = [
    ["x" => 342, "y" => 34],
    ["x" => 234, "y" => 234],
    ["x" => -50, "y" => 100]
];

// Envoyer les données au client au format JSON
header('Content-Type: application/json');
echo json_encode($donnees);
?>
