document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".point").forEach(function (point) {
            checkContinu(point.id);
        });
});


/**
 * Fonction qui permet de vérifier si le point reçoit des messages ou pas
 * @param {string} pointId : L'id du point à vérifier
 */
function checkContinu(pointId) {
    setInterval(function () {
        // Use AJAX to fetch data from the server
        $.ajax({
            url: '../BaseDeDonnees/donnes.php',
            method: 'POST',
            dataType: 'json',
            data:{request: "clignoterPoints"},
            success: function (data) {
                // Récupérer les données
                var target = data.target;

                // Vérifier si le point reçoit des messages ou pas
                if ("177" === pointId) {
                    // Si oui, faire clignoter le point
                    var point = document.getElementById(pointId);
                    toggleSignaling(point);
                }
            },
            error: function (error) {
                console.error('Erreur : ', error);
            }
        });
    }, 100); 
}

/**
 * Fonction qui permet de faire clignoter un point
 * @param {HTMLDivElement} element : Le point à faire clignoter 
 */
function toggleSignaling(element) {
    element.style.opacity = (element.style.opacity == 1) ? 0.25 : 1;
}