document.addEventListener("DOMContentLoaded", function () {
    function fetchStatus() {
        $.ajax({
            url: '../BaseDeDonnees/donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "statusMQTT" },
            success: function (data) {
                console.log(data);
                var currentdate = new Date();
                var timestampexp = data[0].timestamp.split(":");
                var currentminsec = currentdate.getMinutes() + currentdate.getSeconds();
                var minsec = parseInt(timestampexp[1]) + parseInt(timestampexp[2]);
                var diff = currentminsec - minsec;
                if (diff < 2) {
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
    