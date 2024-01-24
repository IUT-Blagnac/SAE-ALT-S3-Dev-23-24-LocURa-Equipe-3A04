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
    let pointOrigine = document.getElementById("CapteurOrigine");
    let pointTarget = document.getElementById($donnees["target"]);

    console.log($donnees["initiator"] + " " + $donnees["target"]);
    console.log(pointOrigine + " "+pointTarget);
    console.log(pointOrigine.style.left + " " + pointOrigine.style.top);
    console.log(pointTarget.style.left + " " + pointTarget.style.top);
    console.log(pointOrigine.getBoundingClientRect());
    console.log(pointTarget.getBoundingClientRect());

    // Calcul des positions des points d'origine et de destination
    let origineRect = pointOrigine.getBoundingClientRect();
    let targetRect = pointTarget.getBoundingClientRect();

    // Calcul des coordonnées du centre des points d'origine et de destination
    let origineX = origineRect.left + origineRect.width / 2;
    let origineY = origineRect.top + origineRect.height / 2;
    let targetX = targetRect.left + targetRect.width / 2;
    let targetY = targetRect.top + targetRect.height / 2;

    // Calcul de la longueur et de l'angle de la ligne
    let distance = Math.sqrt((targetX - origineX) ** 2 + (targetY - origineY) ** 2);
    let angle = Math.atan2(targetY - origineY, targetX - origineX);

    // Création de la ligne
    let ligne = document.createElement("div");
    ligne.className = "ligne";
    ligne.style.position = "absolute";
    ligne.style.left = origineX + "px";
    ligne.style.top = origineY + "px";
    ligne.style.width = distance + "px";
    ligne.style.transform = "rotate(" + angle + "rad)";
    ligne.style.borderBottom = "1px solid black";

    document.getElementById("map").appendChild(ligne);
}