<?php

require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;

// phpinfo();
echo "<a href='Page2.php'>Page 2</a>";

// Listener

$server   = 'lab.iut-blagnac.fr';
$port     = 1883;

$mqtt = new MQTTClient($server, $port);
$mqtt->connect();

$mqtt->subscribe('#', function ($topic, $message, $retained, $matchedWildcards) {
    echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
}, 0);

// Attendez un certain temps pour que le listener puisse recevoir le message
$mqtt->loop(true);

$mqtt->disconnect();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Points Dynamiques avec Origine à 500, 500</title>
    <style>
        #map {
            width: 1000px;
            height: 1000px;
            position: relative;
        }

        .point {
            width: 10px;
            height: 10px;
            position: absolute;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Inclure le fichier JavaScript pour AJAX -->
    <script src="scriptRecupererDonnes.js"></script>
    <!-- Inclure le fichier JavaScript pour créer les points -->
    <script src="scriptCreerPoint.js"></script>
</body>
</html>
