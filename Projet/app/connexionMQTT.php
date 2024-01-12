<?php

require('vendor/autoload.php');

//Logger 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger
$logger = new Logger('mqtt');
$logger->pushHandler(new StreamHandler('log.txt', Logger::INFO));

// Listener
$server   = 'lab.iut-blagnac.fr';
$port     = 1883;

$mqtt = new \PhpMqtt\Client\MqttClient($server, $port,null,\PhpMqtt\Client\MqttClient::MQTT_3_1,null,$logger);
$mqtt->connect();
$mqtt->subscribe('#', function ($topic, $message, $retained, $matchedWildcards) use ($logger) {
    $logger->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
}, 0);
$mqtt->loop(true);
$mqtt->disconnect();


?>