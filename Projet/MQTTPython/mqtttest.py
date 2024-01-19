import json
import paho.mqtt.client as mqtt
import datetime
import time

# Détails du courtier MQTT
broker_address = "lab.iut-blagnac.fr"
broker_port = 1883

# Nom du fichier journal
log_file_name = "mqtt_log.txt"

# Fonction de rappel lorsqu'un message est reçu
def on_message(client, userdata, msg):
        try:
            # Decode the JSON payload
            data = json.loads(msg.payload)

            # Extract data from the JSON payload
            # idCapteur = msg.topic.split('/')[1]
            # x = data.get('x')
            # y = data.get('y')
            # z = data.get('z')
            # orientation = data.get('orientation')
            # color = data.get('color')

            # Print the extracted data
            print(f"{data}")

            # Write the extracted data to the log file
            with open(log_file_name, 'a') as log_file:
                log_file.write(f"{data}\n")

        except Exception as e:
            print(f"Error decoding JSON: {e}")

# Création d'une instance de client MQTT
client = mqtt.Client()

# Connexion au courtier MQTT
client.connect(broker_address, broker_port, 80)

# Configuration des fonctions de rappel
client.on_message = on_message

# Abonnement au topic
client.subscribe("#")

# Démarrage de la boucle du client MQTT
client.loop_start()

# Keep the script running for demonstration purposes
try:
    while True:
        time.sleep(1)
except KeyboardInterrupt:
    print("Interrupted. Exiting.")
    client.loop_stop()
    client.disconnect()
