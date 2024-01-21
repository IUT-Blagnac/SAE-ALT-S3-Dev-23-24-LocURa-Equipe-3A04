<?php

require('vendor/autoload.php');

include('connexionBaseDeDonnees.php');
//Logger 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger
$logger = new Logger('mqtt');
$logger->pushHandler(new StreamHandler('log.txt', Logger::INFO));

// Listener
$server   = 'lab.iut-blagnac.fr';
$port     = 1883;

InitBase();

$mqtt = new \PhpMqtt\Client\MqttClient($server, $port,null,\PhpMqtt\Client\MqttClient::MQTT_3_1,null,$logger);
$mqtt->connect();
$mqtt->subscribe('localisation/+/setup', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    if($retained)
    {
        $logger->info(sprintf("Received retained message on topic [%s]: %s", $topic, $message));
        EnvoyerDonnesNoeud($topic,$message);
    }
    else
    {
        $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
        UpdateDonneesNoeud($topic,$message);
    }
}, 0);
$mqtt->subscribe('testbed/node/+/out', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
    envoyerDonneesComm($topic,$message);

}, 0);
$mqtt->loop(true);
$mqtt->disconnect();

