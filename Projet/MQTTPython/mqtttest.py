import paho.mqtt.client as mqtt

# Détails du courtier MQTT
broker_address = "lab.iut-blagnac.fr"
broker_port = 1883

# Fonction de rappel lorsque le client se connecte au courtier
def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connected to MQTT broker")
    else:
        print("Failed to connect to MQTT broker")

# Fonction de rappel lorsqu'un message est reçu
def on_message(client, userdata, msg):
    print("Received message: " + msg.topic + " " + str(msg.payload))

# Création d'une instance de client MQTT
client = mqtt.Client()

# Connexion au courtier MQTT
client.connect(broker_address, broker_port,80)
# Configuration des fonctions de rappel
client.on_connect = on_connect
client.on_message = on_message

# Démarrage de la boucle du client MQTT
client.loop_start()

# Abonnement au topic
client.subscribe("#")

# Maintien de l'exécution du programme jusqu'à ce qu'il soit interrompu par Ctrl+C
while True:
    pass

