document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        url: 'donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "rangingData"},
        success: function (data) {
            console.log('Données récupérées avec succès :', data);
            GestionDonnees(data);
        },
        error: function(error) {
            console.error('Erreur lors de la récupération des données de ranging :', error);
        }
    });
});
