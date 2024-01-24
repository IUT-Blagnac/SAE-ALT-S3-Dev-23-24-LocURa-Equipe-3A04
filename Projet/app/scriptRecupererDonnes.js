import { createPoints } from './scriptCreerPoint.js';
document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        url: 'donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "pointsFixesData"},
        success: function (data) {
            
            console.log('Données récupérées avec succès :', data);
            // Les données sont récupérées avec succès
            // Appeler une fonction pour créer les points avec les données
            createPoints(data);
            
        },
        error: function(error) {
            console.error(error);
        }
    });
});
