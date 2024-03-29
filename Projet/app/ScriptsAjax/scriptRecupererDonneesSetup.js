import { createPoints } from '../ScriptsCreationElements/scriptCreerPoint.js';
document.addEventListener("DOMContentLoaded", function() {
    /**
     * Fonction pour récupérer les données de la base de données
     */
    function fetchData() {
    $.ajax({
        url: '../BaseDeDonnees/donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "pointsFixesData"},
        success: function (data) {
            
            console.log('Données récupérées avec succès :', data);
            createPoints(data);
            
        },
        error: function(error) {
            console.error(error);
        }
    });
    }

    fetchData();
});
