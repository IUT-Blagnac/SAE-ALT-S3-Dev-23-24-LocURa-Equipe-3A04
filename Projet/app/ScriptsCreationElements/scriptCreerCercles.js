import { COEFF_TT } from "../DiversJavaScripts/constantes.js";

/**
 * Gère le dessin de différents cercles en prenant en paramètre un tableau contenant des données correspondant à une ligne de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
export function GestionDonneesCercles($donnees) {
    SupprimerCercles();
    for (let i = 0; i < $donnees.length; i++) {
        DessinerCercle($donnees[i]);
    }
}

/**
 * Dessine un cercle en fonction d'un tableau de données correspondant au tableau de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
function DessinerCercle($donnees) {

    let centreCercle = document.getElementById($donnees['initiator']);
    let rayon = $donnees['range'] * COEFF_TT; // Ajustez selon votre besoin
    let couleur = centreCercle.style.backgroundColor;

    // Création du cercle
    let cercle = document.createElement("div");
    cercle.classList.add("cercle");
    cercle.classList.add("bordure");
    cercle.style.left = (parseFloat(centreCercle.style.left) - rayon + 4) + "px";
    cercle.style.top = (parseFloat(centreCercle.style.top) - rayon + 4) + "px";
    cercle.style.width = cercle.style.height = 2 * rayon + "px";
    cercle.style.backgroundColor = couleur;
    

    document.getElementById("map").appendChild(cercle);
}

/**
 * Supprime tous les cercles de la carte
 */
function SupprimerCercles() {
    let cercles = document.getElementsByClassName("cercle");
    while (cercles.length > 0) {
        cercles[0].parentNode.removeChild(cercles[0]);
    }
}

