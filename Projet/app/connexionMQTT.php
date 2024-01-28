<?php

require_once('vendor/autoload.php');

require_once('connexionBaseDeDonnees.php');
//Logger 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//Logger pr voir les messages reçus
$logger = new Logger('mqtt');
$logger->pushHandler(new StreamHandler('log.txt', Logger::INFO));

$server   = 'lab.iut-blagnac.fr';
$port     = 1883;

InitBase();


$mqtt = new \PhpMqtt\Client\MqttClient($server, $port,null,\PhpMqtt\Client\MqttClient::MQTT_3_1,null,$logger);
    try{
        $mqtt->connect();
        $isConnected = true;
    }
    catch(Exception $e){
        $logger->info(sprintf("Erreur de connexion au broker MQTT"));
        $isConnected = false;
        exit();
    }
$mqtt->subscribe('localisation/+/setup', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    if($retained)
    {
        $logger->info(sprintf("Received retained message on topic [%s]: %s", $topic, $message));
        EnvoyerDonnesNoeudSetup($topic,$message);
    }
    else
    {
        $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
        UpdateDonneesNoeudSetup($topic,$message);
    }
}, 0);
$mqtt->subscribe('testbed/node/+/out', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
    envoyerDonneesComm($topic,$message);

}, 0);

$mqtt->subscribe('ranging/+/+/indication', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
    EnvoyerDonneesRanging($topic,$message);

}, 0);

$mqtt->subscribe('localisation/+/mobile', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
    if(!str_contains($topic,'dwm')){
        EnvoyerDonneesNoeudMobile($topic,$message);
    }
}, 0);

$mqtt->loop(true);
$mqtt->disconnect();

