<?php

/**
 * Fonction qui gère les données reçues sur les noeuds de setup
 * @param string $topic Le topic du message
 * @param string $message Le message reçu sous format json
 */
function GestionMessageSetup($topic,$message)
{
    $data = json_decode($message,true);
    $idCapteur = explode("/",$topic)[1];
    $x = $data["x"];
    $y = $data["y"];
    $z = $data["z"];
    $orientation = $data["orientation"];
    $color = $data["color"];

    session_start();

    $_SESSION["DonneesSetup"][$idCapteur] = array(
        "x" => $x,
        "y" => $y,
        "z" => $z,
        "orientation" => $orientation,
        "color" => $color
    );

    session_commit();
}
