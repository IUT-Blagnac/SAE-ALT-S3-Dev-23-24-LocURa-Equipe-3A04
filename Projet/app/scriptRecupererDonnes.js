document.addEventListener("DOMContentLoaded", function() {
    // Utiliser AJAX pour récupérer les données du serveur
    $.ajax({
        url: 'donnes.php', // Remplacez 'donnees.php' par le chemin correct vers votre script PHP
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Données récupérées avec succès :', data);

            // Les données sont récupérées avec succès
            // Appeler une fonction pour créer les points avec les données
            createPoints(data);
        },
        error: function(error) {
            console.error('Erreur de requête AJAX :', error);
        }
    });
});