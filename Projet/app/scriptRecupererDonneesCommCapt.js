document.addEventListener("DOMContentLoaded", function () {
    // Definition de la fonction pour recuperer et traiter les données
    function fetchData() {
        $.ajax({
            url: 'donnes.php',
            method: 'post',
            dataType: 'json',
            data: { request: "ClignoterPoints" },
            success: function (data) {
                console.log('Données récupérées avec succès :', data[0]);
                var point = document.getElementById(data[0].idCapteur)
                if(point==null){
                    console.log(" Point en comm : " + data[0].idCapteur)
                    createPoints(data)
                } 
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    // Appel initial de la fonction 
    fetchData();

    // Mettre un intervale pour appeler la fonction toutes les 2 secondes (2000 millisecondes)
    setInterval(fetchData, 2000);
});