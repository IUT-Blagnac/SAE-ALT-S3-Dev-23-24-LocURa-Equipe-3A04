import { createPoints} from '../ScriptsCreationElements/scriptCreerPoint.js';
import { updatePointCoordinates } from '../ScriptsCreationElements/scriptCreerPoint.js';
import { INTERVALLE_MAJ_MOBILE } from '../DiversJavaScripts/constantes.js';
document.addEventListener("DOMContentLoaded", function () {
    /**
     * Fonction pour récupérer les données de la base de données
     */
    function fetchData() {
        $.ajax({
            url: '../BaseDeDonnees/donnes.php',
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

    setInterval(fetchData, INTERVALLE_MAJ_MOBILE);
});