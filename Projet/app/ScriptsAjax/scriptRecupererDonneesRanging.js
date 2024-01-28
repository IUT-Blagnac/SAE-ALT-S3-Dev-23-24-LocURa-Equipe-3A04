import { GestionDonneesCercles } from "../ScriptsCreationElements/scriptCreerCercles.js";
import { GestionDonneesLignes } from "../ScriptsCreationElements/scriptCreerLignes.js";

document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        url: '../BaseDeDonnees/donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "rangingData"},
        success: function (data) {
            console.log('Données récupérées avec succès :', data);
            // Variables de statut pour les cercles et les lignes
            let cerclesActifs = false;
            let lignesActives = false;
            let remplissageActif = true;


             // Fonction pour activer/désactiver les cercles
            function toggleCercles() {
                cerclesActifs = !cerclesActifs;
                // Mettez à jour le texte du bouton en conséquence
                $('.button button:nth-child(1)').text(cerclesActifs ? 'Désactiver Cercles' : 'Activer Cercles');
                const cercles = $('.cercle');

                if (!cerclesActifs) {
                    $('.cercle').remove();
                    $('.button button:nth-child(2)').removeClass("active");
                    $('.button button:nth-child(2)').addClass("hidden");
                    if (!remplissageActif) {
                        console.log("remplissageActif");
                        toggleRemplissage();
                    }
                }
                else {
                    GestionDonneesCercles(data);
                    $('.button button:nth-child(2)').addClass("active");
                    $('.button button:nth-child(2)').removeClass("hidden");
                }

            }

            // Fonction pour activer/désactiver les lignes
            function toggleLignes() {
                lignesActives = !lignesActives;
                // Mettez à jour le texte du bouton en conséquence
                $('.button button:nth-child(3)').text(lignesActives ? 'Désactiver Lignes' : 'Activer Lignes');

                // Ciblez les éléments de lignes par leur classe CSS et ajoutez ou supprimez les éléments
                // Ajoutez le sélecteur approprié pour vos lignes
                if (!lignesActives) {
                    $('.ligne').remove();
                }else{
                    GestionDonneesLignes(data);
                }
            }

            function toggleRemplissage() {
                // Mettez à jour le texte du bouton en conséquence
                $('.button button:nth-child(2)').text(remplissageActif ? 'Désactiver Remplissage' : 'Activer Remplissage');

                const cercles = $('.cercle');

                // Ciblez les éléments de remplissage par leur classe CSS et ajoutez ou supprimez les éléments
                // Ajoutez le sélecteur approprié pour vos lignes
                if (!remplissageActif) {
                    cercles.removeClass("background");
                } else {
                    cercles.addClass("background");
                    console.log(cercles);
                }
                remplissageActif = !remplissageActif;

            }

            // Ajoutez des écouteurs d'événements aux boutons
            $('.button button:nth-child(1)').on('click', toggleCercles);

            $('.button button:nth-child(2)').on('click', toggleRemplissage);

            $('.button button:nth-child(3)').on('click', toggleLignes);
        },
        error: function(error) {
            console.error('Erreur lors de la récupération des données de ranging :', error);
        }
    });
});



