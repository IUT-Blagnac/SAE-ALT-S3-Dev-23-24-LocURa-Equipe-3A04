import {COEFF_TT} from "../DiversJavaScripts/constantes.js";

/**
 * Gere le dessins de différentes lignes en prenant en paramètre un tableau qui contient des tableaux de données correspondant a une ligne de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
export function GestionDonneesLignes($donnees)
{
    SupprimerLignes();
    for(let i = 0; i < $donnees.length; i++)
    {
        DessinerLigne($donnees[i]);
    }
}

/**
 * Dessine une ligne en fonction d'un tableau de données correspondant au tableau de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
function DessinerLigne($donnees)
{
    let pointInit = document.getElementById($donnees["initiator"]);
    let pointTarget = document.getElementById($donnees["target"]);

    // Calcul des coordonnées du centre des points d'origine et de destination
    let origineX = parseFloat(pointInit.style.left);
    let origineY = parseFloat(pointInit.style.top);
    let targetX = parseFloat(pointTarget.style.left);
    let targetY = parseFloat(pointTarget.style.top);

    // Calcul de la longueur et de l'angle de la ligne
    let distance = Math.sqrt((targetX - origineX) ** 2 + (targetY - origineY) ** 2); // INUTILE
    let angle = Math.atan2(targetY - origineY, targetX - origineX)*180/Math.PI;

    //On fait une deuxieme ligne qui montre le vrai range multiplié par 38
    let ligne = document.createElement("div");
    ligne.className = "ligne";
    ligne.style.left = (origineX+4)+ "px"; //Pour se placer au milieu du point
    ligne.style.top = (origineY+4) + "px";
    ligne.style.width = $donnees['range']*COEFF_TT + "px"; // A Changer pr range
    ligne.style.transform = "rotate(" + angle + "deg)";
    ligne.style.backgroundColor = "black";

    // On rajoute une ligne a la suite de la ligne2 pour affiicher la ranging error $donnees['rangeError']
    let ligne3 = document.createElement("div");
    ligne3.className = "ligne3";
    ligne3.style.left = (origineX +4) + "px";
    ligne3.style.top = (origineY +4 + parseInt(ligne.style.top) + parseInt(ligne.style.height)) + "px";
    ligne3.style.width = $donnees['rangingError'] * COEFF_TT + "px";
    ligne3.style.transform = "rotate(" + angle + "deg)";
    if($donnees['rangingError'] > 0)
    {
        ligne3.style.backgroundColor = "red";
    }
    else 
    {
        ligne3.style.backgroundColor = "blue";
    }
    ligne3.style.zIndex = "998";



    document.getElementById("map").appendChild(ligne);
    document.getElementById("map").appendChild(ligne3);
}

/**
 * Supprime toutes les lignes du document
 */
function SupprimerLignes()
{
    let lignes = document.getElementsByClassName("ligne");
    while(lignes.length > 0)
    {
        lignes[0].parentNode.removeChild(lignes[0]);
    }

    let lignes3 = document.getElementsByClassName("ligne3");
    while(lignes3.length > 0)
    {
        lignes3[0].parentNode.removeChild(lignes3[0]);
    }
}