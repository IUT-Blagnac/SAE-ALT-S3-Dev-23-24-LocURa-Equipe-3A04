import paho.mqtt.client as mqtt

def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connexion au courtier MQTT réussie")
        client.subscribe("localisation/+/mobile")
    else:
        print("Connexion au courtier MQTT échouée")

def on_message(client, userdata, msg):
    print(msg.topic, msg.payload)

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("lab.iut-blagnac.fr", 1883)

client.loop_forever()
