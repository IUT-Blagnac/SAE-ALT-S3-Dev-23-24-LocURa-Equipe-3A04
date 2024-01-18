import json
import paho.mqtt.client as mqtt
import mariadb
import sys


# Détails du courtier MQTT
broker_address = "lab.iut-blagnac.fr"
broker_port = 1883

file_object  = open("log.txt", "w")

try:
    conn = mariadb.connect(
        user="UserBd",
        password="MotDePasseBD",
        host="BaseDeDonnes",
        port=3306,
        database="Donnes"
    )
except mariadb.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    sys.exit(1)



# Fonction de rappel lorsque le client se connecte au courtier
def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connected to MQTT broker")
    else:
        print("Failed to connect to MQTT broker")

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
        # print(f"idCapteur: {idCapteur}, x: {x}, y: {y}, z: {z}, orientation: {orientation}, color: {color}")
        file_object.write(f"idCapteur: {idCapteur}, x: {x}, y: {y}, z: {z}, orientation: {orientation}, color: {color} TEST! \n")
        
        # Insert the data into the database
        cursor = conn.cursor()
        cursor.execute("INSERT INTO DonneesCapteurs (idCapteur, x, y, z, orientation, color) VALUES (%s, %s, %s, %s, %s, %s)", (idCapteur, x, y, z, orientation, color))
        conn.commit()
        cursor.close()
    except mariadb.Error as err:
        print(f"Erreur MariaDB : {err}")
        # Gérer l'erreur ici, par exemple, en annulant la transaction
        conn.rollback()
    except Exception as e:
        print(f"Error decoding JSON: {e}")

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
client.subscribe("localisation/+/setup")

# Maintien de l'exécution du programme jusqu'à ce qu'il soit interrompu par Ctrl+C
while True:
    pass
