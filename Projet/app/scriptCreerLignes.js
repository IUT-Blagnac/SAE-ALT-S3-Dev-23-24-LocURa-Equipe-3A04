/**
 * Gere le dessins de différentes lignes en prenant en paramètre un tableau qui contient des tableaux de données correspondant a une ligne de données dans la base de données Ranging
 * @param {Array} $donnees 
 */
function GestionDonnees($donnees)
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
    let pointInit = document.getElementById($donnees["initiator"]);
    let pointTarget = document.getElementById($donnees["target"]);

    console.log(pointInit.style.left + " " + pointInit.style.top);
    console.log(pointTarget.style.left + " " + pointInit.style.top);
}