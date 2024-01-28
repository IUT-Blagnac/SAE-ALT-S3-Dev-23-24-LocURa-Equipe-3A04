document.addEventListener("DOMContentLoaded", function () {
    function fetchStatus() {
        $.ajax({
            url: 'donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "statusMQTT" },
            success: function (data) {
                console.log('Status MQTT:', data[0].timestamp);
                var currentdate = new Date();
                var timestampexp = data[0].timestamp.split(":");
                var currentminsec = currentdate.getMinutes() + currentdate.getSeconds();
                var minsec = parseInt(timestampexp[1]) + parseInt(timestampexp[2]);
                console.log(minsec);
                var diff = currentminsec - minsec;
                console.log(diff);
                if (diff < 5) {
                    $('#mqtt_spinner').removeClass('text-danger').addClass('text-success');
                } else {
                    $('#mqtt_spinner').removeClass('text-success').addClass('text-danger');
                }
            },
        });
    }
        fetchStatus();

        setInterval(fetchStatus, 1000);
    });
    