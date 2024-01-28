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
                console.log('Données récupérées avec succès :', data[0]);
                var point = document.getElementById(data[0].idCapteur)
                if(point==null){
                    console.log(" Creation de : " + data[0].idCapteur)
                    createPoints(data)
                } else {
                    console.log("Mise à jour de : " + data[0].idCapteur);
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