/**
 * Gere le dessins de différentes lignes en prenant en paramètre un tableau qui contient des tableaux de données correspondant a une ligne de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
export function GestionDonneesLignes($donnees)
{
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
    // let pointInit = document.getElementById($donnees["initiator"]);
    let pointInit = document.getElementById("CapteurOrigine"); // Pour debug
    let pointTarget = document.getElementById($donnees["target"]);

    // Calcul des coordonnées du centre des points d'origine et de destination
    let origineX = parseFloat(pointInit.style.left);
    let origineY = parseFloat(pointInit.style.top);
    let targetX = parseFloat(pointTarget.style.left);
    let targetY = parseFloat(pointTarget.style.top);

    // Calcul de la longueur et de l'angle de la ligne
    let distance = Math.sqrt((targetX - origineX) ** 2 + (targetY - origineY) ** 2);
    let angle = Math.atan2(targetY - origineY, targetX - origineX)*180/Math.PI;

    // Création de la ligne
    let ligne = document.createElement("div");
    ligne.className = "ligne";
    ligne.style.left = (origineX+5)+ "px"; //Pour se placer au milieu du point
    ligne.style.top = (origineY+5) + "px";
    ligne.style.width = distance + "px"; // A Changer pr range
    ligne.style.transform = "rotate(" + angle + "deg)";

    //On fait une deuxieme ligne qui montre le vrai range multiplié par 38
    let ligne2 = document.createElement("div");
    ligne2.className = "ligne2";
    ligne2.style.left = (origineX+5)+ "px"; //Pour se placer au milieu du point
    ligne2.style.top = (origineY+5) + "px";
    ligne2.style.width = $donnees['range']*38 + "px"; // A Changer pr range
    ligne2.style.transform = "rotate(" + angle + "deg)";
    ligne2.style.backgroundColor = "red";
    ligne2.style.opacity = "0.5";
    ligne2.style.zIndex = "1001";


    document.getElementById("map").appendChild(ligne);
    document.getElementById("map").appendChild(ligne2);
}