document.addEventListener("DOMContentLoaded", function() {
    // Utiliser AJAX pour récupérer les données du serveur
    $.ajax({
        url: 'donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "pointMobile"},
        success: function (data) {
            console.log('Données récupérées avec succès :', data);

            createPoints(data);
        },
        error: function(error) {
            console.error(error);
        }
    });
});