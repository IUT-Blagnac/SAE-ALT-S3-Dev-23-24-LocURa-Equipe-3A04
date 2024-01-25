document.addEventListener("DOMContentLoaded", function() {
    // Utiliser AJAX pour récupérer les données du serveur
    $.ajax({
        url: 'donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "pointMobile"},
        success: function (data) {
            console.log('Données récupérées avec succès :', data);

            var id = data.id;
            var coordX = data.x + 10;
            var coordY = data.y + 10;
            var couleur = data.color;
            createPoint(coordX, coordY, couleur, id, null, null)
        },
        error: function(error) {
            console.error(error);
        }
    });
});
