document.addEventListener("DOMContentLoaded", function() {
    // Utiliser AJAX pour récupérer les données du serveur
    $.ajax({
        url: 'donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "ranging"},
        success: function (data) {
            console.log('Données récupérées avec succès :', data);

            // Les données sont récupérées avec succès
            // Appeler une fonction pour créer les points avec les données
            createPoints(data);
        },
        error: function(error) {
            console.error('Données non récupérées :', error);
        }
    });
});
