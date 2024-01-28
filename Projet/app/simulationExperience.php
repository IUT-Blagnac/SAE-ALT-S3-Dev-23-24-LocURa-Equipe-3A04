<?php
require_once('connexionBaseDeDonnees.php');

while (true) {
    
    SimulationDonneesNoeudMobile();
    SimulationDonneesRangingFixe();
    SimulationDonneesRangingMobile();

    // Ralentir la boucle
    sleep(2);
}

/**
 * Simule le mouvement du noeud mobile de manière aléatoire
 * @return void
 */
function SimulationDonneesNoeudMobile()
{
    $x = rand(0, 10) + 0.258;
    $y = rand(0, 10) + 0.208;
    EnvoyerDonneesNoeudMobile('localisation/183/mobile', '{"timestamp": 0, "x":'.$x.', "y": '.$y.', "z": 2.65, "type": "mobile", "color": "FFFFFF", "UID": "DD94"}');
}

/**
 * Simule des données de ranging qui proviennent du noeud mobile
 */
function SimulationDonneesRangingMobile()
{
    $initiator=183; //
    $target=109; //
    $fausseDonnesranging = '{"initiator": "183", "target": "177", "range": 3.8443,  "timestamp": 1705656017704, "localisation": {"initiator": {"x": 1.407, "y": 4.078, "z": 2.65}, "target": {"x": 5.057, "y": 2.714, "z": 2.65}}, "distance": 3.897, "rangingError": -0.052}';

}

/**
 * Simule des données de ranging qui proviennent d"un noeud fixe vers un autre noeud fixe
 */
function SimulationDonneesRangingFixe()
{
    $initiator=110;
    $target=109; 
    $range = 3+rand(-1,1)/10;
    $rangingError = rand(-1,1)/10;
    $fausseDonnesranging = '{"initiator":'.$initiator.', "target": '.$target.', "range":'.$range.',  "timestamp": 1705656017704, "rangingError": '.$rangingError.'}';

    EnvoyerDonneesRanging('ranging/'.$initiator.'/'.$target.'/indication', $fausseDonnesranging);
}