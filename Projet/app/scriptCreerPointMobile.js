import { createPoints } from './scriptCreerPoint.js';
document.addEventListener("DOMContentLoaded", function () {
    // Define a function to fetch and process data
    function fetchData() {
        $.ajax({
            url: 'donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "pointMobile" },
            success: function (data) {
                console.log('Données récupérées avec succès :', data);
                if(document.getElementById(data.idCapteur)==null){
                    createPoints(data);
                } else {
                    var point = document.getElementById(data.idCapteur);
                    point.style.left = data.x * COEFF_X + X_ORIGINE_C + "px";
                    point.style.top = data.y * COEFF_Y + Y_ORIGINE_C + "px";
                }
                
            
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    // Call the function initially
    fetchData();

    // Set up an interval to call the function every, for example, 5 seconds (5000 milliseconds)
    setInterval(fetchData, 5000);
});