/**
 * Gère le dessin de différents cercles en prenant en paramètre un tableau contenant des données correspondant à une ligne de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
export function GestionDonneesCercles($donnees) {
    for (let i = 0; i < $donnees.length; i++) {
        DessinerCercle($donnees[i]);
    }
}

/**
 * Dessine un cercle en fonction d'un tableau de données correspondant au tableau de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
function DessinerCercle($donnees) {

    let centreCercle = document.getElementById("CapteurOrigine");
    let rayon = $donnees['range'] * 38; // Ajustez selon votre besoin

    // Création du cercle
    let cercle = document.createElement("div");
    cercle.classList.add("cercle");
    cercle.classList.add("bordure");
    cercle.classList.add("background");
    cercle.style.left = (parseFloat(centreCercle.style.left) - rayon + 5) + "px";
    cercle.style.top = (parseFloat(centreCercle.style.top) - rayon + 5) + "px";
    cercle.style.width = cercle.style.height = 2 * rayon + "px";
    

    document.getElementById("map").appendChild(cercle);
}

