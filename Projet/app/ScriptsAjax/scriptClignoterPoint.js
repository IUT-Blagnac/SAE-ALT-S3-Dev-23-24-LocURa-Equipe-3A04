document.addEventListener("DOMContentLoaded", function () {
    // Definition de la fonction pour recuperer et traiter les données
    function fetchData() {
        $.ajax({
            url: '../BaseDeDonnees/donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "ClignoterPoints" },
            success: function (data) {

                for (var i = 0; i < data.length; i++) {
                    console.log(" Point en comm : " + data[i].idCapteur)
                    var point = document.getElementById(data[i].idCapteur);
                        point.style.opacity = 0.25;

                    // Clignoter le point
                        point.style.opacity = (point.style.opacity == 0.25) ? 1 : 0.25;

                        point.style.opacity = 1;
                }
            },
        });
    }

    // Appel initial de la fonction 
    fetchData();

    // Mettre un intervale pour appeler la fonction toutes les 500 secondes (500 millisecondes)
    setInterval(fetchData, 500);
});