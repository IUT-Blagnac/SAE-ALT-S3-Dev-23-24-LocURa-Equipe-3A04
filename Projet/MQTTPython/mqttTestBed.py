import os
import paho.mqtt.client as mqtt

# MQTT broker details
broker_address = "lab.iut-blagnac.fr"
broker_port = 1883
topic = "testbed/node/+/out"

# Callback function for when a connection is established
def on_connect(client, userdata, flags, rc):
    print("Connexion marche")
    client.subscribe(topic)

# Callback function for when a message is received
def on_message(client, userdata, msg):
    print(f"Message: {msg.payload.decode()}")

    # # Open the log file in append mode
    # with open("log.txt", "a") as file:
    #     # Write the received message to the file
    #     file.write(f"Topic : {msg.topic} Message: {msg.payload.decode()}\n")
        

# Create MQTT client instance
client = mqtt.Client()

# Set callback functions
client.on_connect = on_connect
client.on_message = on_message

# Connect to MQTT broker
client.connect(broker_address, broker_port)

# Start the MQTT loop
client.loop_forever()
