import { GestionDonneesCercles } from "./scriptCreerCercles.js";
import { GestionDonneesLignes } from "./scriptCreerLignes.js";

document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        url: 'donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "rangingData"},
        success: function (data) {
            console.log('Données récupérées avec succès :', data);
            GestionDonneesCercles(data);
            GestionDonneesLignes(data);
        },
        error: function(error) {
            console.error('Erreur lors de la récupération des données de ranging :', error);
        }
    });
});


