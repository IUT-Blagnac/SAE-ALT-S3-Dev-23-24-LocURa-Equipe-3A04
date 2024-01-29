import { GestionDonneesCercles } from "../ScriptsCreationElements/scriptCreerCercles.js";
import { GestionDonneesLignes } from "../ScriptsCreationElements/scriptCreerLignes.js";
import { INTERVALLE_MAJ_RANGING } from "../DiversJavaScripts/constantes.js";

let cerclesActifs = false;
let lignesActives = false;
let remplissageActif = true;

document.addEventListener("DOMContentLoaded", function() {
   
    $('.button button:nth-child(1)').on('click', toggleCercles);
    $('.button button:nth-child(2)').on('click', toggleRemplissage);
    $('.button button:nth-child(3)').on('click', toggleLignes);

    /**
     * Recupère les données de la base de données et les affiche si nécessaire
     */
    function fetchData()
    {
        $('.button button:nth-child(1)').text(cerclesActifs ? 'Désactiver Cercles' : 'Activer Cercles');
        $('.button button:nth-child(2)').text(remplissageActif ? 'Désactiver Remplissage' : 'Activer Remplissage');
        $('.button button:nth-child(3)').text(lignesActives ? 'Désactiver Lignes' : 'Activer Lignes');

        $.ajax({
            url: '../BaseDeDonnees/donnes.php',
            method: 'post',
            dataType: 'json',
            data:{request: "rangingData"},
            success: function (data) {
                if(cerclesActifs){
                    GestionDonneesCercles(data);
                    $('.button button:nth-child(2)').addClass("active");
                    $('.button button:nth-child(2)').removeClass("hidden");

                    if (!remplissageActif) {
                        $('.cercle').removeClass("background");
                    } else { 
                        $('.cercle').addClass("background");
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
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des données de ranging :', error);
            }
        });
    }

    /**
     *  Fonction pour activer/désactiver les cercles
     */ 
    function toggleCercles() {
        cerclesActifs = !cerclesActifs;
        fetchData();
    }

    /**
     * Fonction pour activer/désactiver les lignes
     */
    function toggleLignes() {
        lignesActives = !lignesActives;  
        fetchData();              
    }

    /**
     * Fonction pour activer/désactiver le remplissage des cercles
     */
    function toggleRemplissage() {
        remplissageActif = !remplissageActif;
        fetchData(); 
    }

    fetchData();

    setInterval(fetchData, INTERVALLE_MAJ_RANGING);

});



