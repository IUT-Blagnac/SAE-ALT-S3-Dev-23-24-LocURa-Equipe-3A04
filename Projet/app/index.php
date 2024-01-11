<?php

// phpinfo();
echo "<a href='Page2.php'>Page 2</a>";
use PhpMqtt\Client\MqttClient;

// Broker

$broker = new MqttClient('tcp://localhost:1883', 'BrokerClient');
$broker->connect();

$message = 'Hello from the Broker!';
$broker->publish('topic/broker', $message, 0, true);

$broker->disconnect();

// Listener

$listener = new MqttClient('tcp://localhost:1883', 'ListenerClient');
$listener->connect();

$listener->subscribe('topic/broker', function ($topic, $message) {
    echo "Received message on topic '$topic': $message\n";
});

// Attendez un certain temps pour que le listener puisse recevoir le message
sleep(5);

$listener->disconnect();

?>