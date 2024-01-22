import paho.mqtt.client as mqtt
import json;
def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connexion au courtier MQTT réussie")
        client.subscribe("localisation/+/setup")
    else:
        print("Connexion au courtier MQTT échouée")

# Fonction de rappel lorsqu'un message est reçu
def on_message(client, userdata, msg):
    try:
        # Decode the JSON payload
        data = json.loads(msg.payload)
        
        # Extract data from the JSON payload
        idCapteur = msg.topic.split('/')[1]
        x = data.get('x')
        y = data.get('y')
        z = data.get('z')
        orientation = data.get('orientation')
        color = data.get('color')
        
        
        # Print the extracted data
        print(f"idCapteur: {idCapteur}, x: {x}, y: {y}, z: {z}, orientation: {orientation}, color: {color}")
    except Exception as e:
        print(f"Error decoding JSON: {e}")

# Création d'une instance de client MQTT
client = mqtt.Client()

# Connexion au courtier MQTT
client.connect("lab.iut-blagnac.fr",1883)
# Configuration des fonctions de rappel
client.on_connect = on_connect
client.on_message = on_message

# Démarrage de la boucle du client MQTT
client.loop_forever()

# Abonnement au topic


