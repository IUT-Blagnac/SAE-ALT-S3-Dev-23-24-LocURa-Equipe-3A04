import { INTERVALLE_MAJ_COMM_CAPT,CLIGNOTEMENT_DUREE,CLIGNOTEMENT_INTERVALLE } from "../DiversJavaScripts/constantes";
document.addEventListener("DOMContentLoaded", function () {
    // Definition de la fonction pour recuperer et traiter les données
    function fetchData() {
        $.ajax({
            url: 'donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "ClignoterPoints" },
            success: function (data) {
                console.log('Données récupérées avec succès :', data);

                console.log(" Point en comm : " + data[0].idCapteur)
                createPoints(data)
                for (var i = 0; i < data.length; i++) {
                    console.log(" Point en comm : " + data[i].idCapteur)
                    var point = document.getElementById(data[i].idCapteur);
                    point.style.opacity = 0.25;

                    // Clignoter le point
                    var interval = setInterval(function () {
                        point.style.opacity = (point.style.opacity == 0.25) ? 1 : 0.25;
                    }, CLIGNOTEMENT_INTERVALLE); // Clignoter toutes les cliognotementIntervalles millisecondes

                    // Arret de clignotement après l'intervalle de temps défini
                    setTimeout(function () {
                        clearInterval(interval);
                        point.style.opacity = 1;
                    },CLIGNOTEMENT_DUREE); 
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
    setInterval(fetchData, INTERVALLE_MAJ_COMM_CAPT);
});