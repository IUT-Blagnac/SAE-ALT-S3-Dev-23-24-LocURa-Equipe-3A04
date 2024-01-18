<?php

$donnees = [
    ["x" => 0, "y" => 0, "couleur" => "red", "id"=>"Origine"],
    ["x" => 0.336, "y" => 0.89, "couleur" => "blue","id"=>"17"],
    ["x" => 0.773, "y" => 0.364, "couleur" => "green","id"=>"18"],
    ["x" => 5.071, "y" => 5.29, "couleur" => "purple","id"=>"25"],
    ["x" => 5.057, "y" => 2.714, "couleur" => "yellow","id"=>"177"],
    ["x"=> 15.312, "y"=> 4.93, "couleur" => "red","id"=>"69"]
];

// Envoyer les données au client au format JSON
header('Content-Type: application/json');
echo json_encode($donnees);
?>
