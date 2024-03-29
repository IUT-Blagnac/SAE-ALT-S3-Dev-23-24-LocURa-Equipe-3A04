import { COEFF_X, X_ORIGINE_C,COEFF_Y,Y_ORIGINE_C } from '../DiversJavaScripts/constantes.js';

document.addEventListener("DOMContentLoaded", function () {
    

    // Coordonnées des points de début et de fin
    var startX = 2.120 * COEFF_X + X_ORIGINE_C;
    console.log(startX);
    var startY = 2.793 * COEFF_Y + Y_ORIGINE_C;
    console.log(startY);
    var endX = 1100;
    var endY = 570;

    // Calcul de la longueur et de l'angle du trait
    var length = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2))+60;
    var angle = Math.atan2(endY - startY, endX - startX) * (180 / Math.PI)+8;

    // Appliquer la transformation
    var ligne = document.getElementById("ligneMobile");
    ligne.style.width = length + "px";
    ligne.style.transform = "rotate(" + angle + "deg)";
    ligne.style.top = startY + "px";
    ligne.style.left = startX + "px";
    
});