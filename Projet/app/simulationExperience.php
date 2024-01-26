<?php

$cpt = 0;
while (true) {
    
    SimulationDonneesNoeudMobile($cpt);
    SimulationDonneesRangingFixe($cpt);
    SimulationDonneesRangingMobile($cpt);

    $cpt++;
    // Ralentir la boucle
    sleep(2);
}

/**
 * Simule le mouvement du noeud mobile de manière aléatoire
 * @param int $cpt
 * @return void
 */
function SimulationDonneesNoeudMobile($cpt)
{
    $timestamp = 1706223659.6738627 + $cpt;
    $x = rand(0, 10) + 0.258;
    $y = rand(0, 10) + 0.208;
    EnvoyerDonneesNoeudMobile('localisation/183/mobile', '{"timestamp": '.$timestamp.', "x":'.$x.', "y": '.$y.', "z": 2.65, "type": "mobile", "color": "FFFFFF", "UID": "DD94"}');
}

/**
 * Simule des données de ranging qui proviennent du noeud mobile
 * @param int $cpt
 */
function SimulationDonneesRangingMobile($cpt)
{
    $timestamp = 1706223659.6738627 + $cpt;
    
}

/**
 * Simule des données de ranging qui proviennent d'un noeud fixe vers un autre noeud fixe
 * @param int $cpt
 */
function SimulationDonneesRangingFixe($cpt)
{

}