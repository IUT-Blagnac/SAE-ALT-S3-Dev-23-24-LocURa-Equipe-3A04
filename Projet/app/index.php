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