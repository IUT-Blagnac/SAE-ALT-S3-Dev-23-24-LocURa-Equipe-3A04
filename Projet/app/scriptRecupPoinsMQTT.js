    var MQTT_URL = "mqtt://";
    var MQTT_Client_ID = String(Math.floor(Math.random() * 9e22));
	var MQTT_Client = "";
    mqtt_Connect_with_Broker();

	function mqtt_Connect_with_Broker()
    {
	  MQTT_Client = new Paho.MQTT.Client("lab.iut-blagnac.fr",1883,"/mqtt",MQTT_Client_ID);
	  MQTT_Client.onMessageArrived = onMessageArrived;
	  MQTT_Client.onConnectionLost = onConnectionLost;
	  MQTT_Client.connect({onSuccess:onConnect});
	}

    function onConnectionLost()
    {
	  console.log("Connexion au broker MQTT perdue");
      MQTT_Client.connect({onSuccess:onConnect});
	}

	function onConnect()
    {
	  console.log("Connexion au broker MQTT réussie");
	//   MQTT_Client.subscribe("ranging/#");
	  MQTT_Client.subscribe("localisation/#/mobile");
	//   MQTT_Client.subscribe("estimator");
	//   MQTT_Client.subscribe("rail/1/localisation/indication");
	//   MQTT_Client.subscribe("stats");
	}

    function onMessageArrived(message)
    {
		msg = JSON.parse(message.payloadString);
        console.log(msg);
	     if( message.destinationName.split('/')[0] == "localisation")
		{
			msg.name = message.destinationName.split('/')[1];
			if ( msg.type == "setup" ) 
			{;
				createPoints
			}
			else if ( msg.type == "mobile" )
			{
				createPoint(msg.x,msg.y,msg.color,msg.destinationName[2],"",msg.UID);
			}
		}
	}
