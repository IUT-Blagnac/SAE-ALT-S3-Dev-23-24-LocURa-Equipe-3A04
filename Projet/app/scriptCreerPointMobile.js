import { createPoints} from './scriptCreerPoint.js';
import { updatePointCoordinates } from './scriptCreerPoint.js';
document.addEventListener("DOMContentLoaded", function () {
    // Definition de la fonction pour recuperer et traiter les données
    function fetchData() {
        $.ajax({
            url: 'donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "pointMobile" },
            success: function (data) {
                var point = document.getElementById(data[0].idCapteur)
                if(point==null){
                    createPoints(data)
                } else {
                    updatePointCoordinates(point,data[0].x,data[0].y);
                }
                
            
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    // Appel initial de la fonction 
    fetchData();

    // Mettre un intervale pour appeler la fonction toutes les 2 secondes (2000 millisecondes)
    setInterval(fetchData, 2000);
});