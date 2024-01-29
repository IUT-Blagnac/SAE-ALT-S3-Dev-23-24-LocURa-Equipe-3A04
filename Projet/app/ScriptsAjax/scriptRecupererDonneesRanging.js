import { GestionDonneesCercles } from "../ScriptsCreationElements/scriptCreerCercles.js";
import { GestionDonneesLignes } from "../ScriptsCreationElements/scriptCreerLignes.js";
import { INTERVALLE_MAJ_RANGING } from "../DiversJavaScripts/constantes.js";

let cerclesActifs = false;
let lignesActives = false;
let remplissageActif = true;

document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        url: '../BaseDeDonnees/donnes.php',
        method: 'post',
        dataType: 'json',
        data:{request: "rangingData"},
        success: function (data) {
            $('.button button:nth-child(1)').text(cerclesActifs ? 'Désactiver Cercles' : 'Activer Cercles');
            $('.button button:nth-child(2)').text(remplissageActif ? 'Désactiver Remplissage' : 'Activer Remplissage');
            $('.button button:nth-child(3)').text(lignesActives ? 'Désactiver Lignes' : 'Activer Lignes');

            $('.button button:nth-child(1)').on('click', toggleCercles);
            $('.button button:nth-child(2)').on('click', toggleRemplissage);
            $('.button button:nth-child(3)').on('click', toggleLignes);

            /**
             * Recupère les données de la base de données et les affiche si nécessaire
             */
            function fetchData()
            {
                console.log('Données récupérées avec succès :', data);

                if(cerclesActifs){
                    GestionDonneesCercles(data);
                    $('.button button:nth-child(2)').addClass("active");
                    $('.button button:nth-child(2)').removeClass("hidden");

                    if (!remplissageActif) {
                        cercles.removeClass("background");
                    } else {
                        cercles.addClass("background");
                        console.log(cercles);
                    }
                }
                else 
                {
                    $('.cercle').remove();
                    $('.button button:nth-child(2)').removeClass("active");
                    $('.button button:nth-child(2)').addClass("hidden");
                    if (!remplissageActif) {
                        console.log("remplissageActif");
                        toggleRemplissage();
                    }
                }

                if (!lignesActives) {
                    $('.ligne').remove();
                }else{
                    GestionDonneesLignes(data);
                }
            }

            /**
             *  Fonction pour activer/désactiver les cercles
             */ 
            function toggleCercles() {
                cerclesActifs = !cerclesActifs;
            }

            /**
             * Fonction pour activer/désactiver les lignes
             */
            function toggleLignes() {
                lignesActives = !lignesActives;                
            }

            /**
             * Fonction pour activer/désactiver le remplissage des cercles
             */
            function toggleRemplissage() {
                remplissageActif = !remplissageActif;
            }


            fetchData();

            setInterval(fetchData, INTERVALLE_MAJ_RANGING);
        },
        error: function(error) {
            console.error('Erreur lors de la récupération des données de ranging :', error);
        }
    });
});



