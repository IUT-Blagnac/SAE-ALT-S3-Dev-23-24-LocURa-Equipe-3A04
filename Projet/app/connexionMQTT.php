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

//TEMPORAIRE PR TEST
// EnvoyerDonneesRanging('ranging/183/184/indication','{"initiator": "183", "target": "184", "protocol": "UWB_RSSI", "RSSI_3samples": -84.000183, "range": 1.2048, "range_1sample": 1.098334, "range_3samples": 1.2048, "range_6samples": 1.189809, "range_9samples": 1.204596, "timestamp": 1705655955875, "localisation": {"initiator": {"x": 1.407, "y": 4.078, "z": 2.65}, "target": {"x": 2.12, "y": 2.793, "z": 2.65}}, "distance": 1.47, "rangingError": -0.265}');
// EnvoyerDonneesRanging('ranging/183/172/indication','{"initiator": "183", "target": "172", "protocol": "TWR", "t1": 840596333714, "t2": 570872145553, "t3": 570971261074, "t4": 840695449901, "skew": 1.199784, "skewRequest": -1.322839, "skewAck": 1.199784, "skewData": 2.061167, "nlosIndicator": 1.30886, "tof": 333, "tofSkew": 273.541401, "tof3Skew": 257.27922, "range": 1.206728, "rangeSkew": 1.283004, "range3Skew": 1.206728, "rangeNoSkew": 1.561885, "ranging unit": "m", "seqnum": 2146, "rssiRequest": -83.245018, "rssiData": -82.785902, "rssiAck": -82.729289, "fp_powerRequest": -86.008728, "fp_powerAck": -85.652947, "fp_powerData": -85.66999, "pa_powerRequest": -88.544739, "pa_powerAck": -87.93421, "pa_powerData": -88.144278, "temperature": 63.185001, "distantTemperature": 29.080002, "timestamp": 1705655956454, "localisation": {"initiator": {"x": 1.407, "y": 4.078, "z": 2.65}, "target": {"x": 0.347, "y": 3.294, "z": 2.65}}, "distance": 1.318, "rangingError": -0.112}');



while (true) {
    // Simulation de la réception de données
    // $topic = 'ranging/+/+/indication';
    // $range = rand(1, 10) + 0.258;
    // $target = rand(142,154);
    // $message = '{"initiator": "183", "target": "' . $target . '", "protocol": "UWB_RSSI", "RSSI_3samples": -84.000183, "range":"'.$range.'", "range_1sample": 1.098334, "range_3samples": 1.2048, "range_6samples": 1.189809, "range_9samples": 1.204596, "timestamp": 1705655955875, "localisation": {"initiator": {"x": 1.407, "y": 4.078, "z": 2.65}, "target": {"x": 2.12, "y": 2.793, "z": 2.65}}, "distance": 1.47, "rangingError": -0.265}';
    
    // Appeler la fonction d'envoi de données
    // EnvoyerDonneesRanging($topic, $message);
    
    $timestamp = 1706223659.6738627 + 1;
    $x = rand(0, 10) + 0.258;
    $y = rand(0, 10) + 0.208;
    EnvoyerDonneesNoeudMobile('localisation/183/mobile', '{"timestamp": 1706223659.6738627, "x":'.$x.', "y": '.$y.', "z": 2.65, "type": "mobile", "color": "FF0000", "UID": "DD94"}');
    // Ralentir la boucle
    sleep(1);
}

$mqtt = new \PhpMqtt\Client\MqttClient($server, $port,null,\PhpMqtt\Client\MqttClient::MQTT_3_1,null,$logger);
$mqtt->connect();
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

