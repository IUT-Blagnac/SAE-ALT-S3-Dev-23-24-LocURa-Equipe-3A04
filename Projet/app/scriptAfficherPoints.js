$(document).ready(function() {
    // Détecter les changements dans les cases à cocher de Noeuds
    $('#nodes input[type="checkbox"]').change(function() {
        // Mettre à jour la visibilité des nœuds en fonction des cases à cocher
        updateNodeVisibility();
    });

    // Fonction pour mettre à jour la visibilité des nœuds
    function updateNodeVisibility() {
        // Parcourir toutes les cases à cocher de Noeuds
        $('#nodes input[type="checkbox"]').each(function() {
            // Récupérer l'ID du nœud correspondant à la case à cocher
            var nodeId = $(this).attr('id');

            // Récupérer l'état de la case à cocher (cochée ou non)
            var isChecked = $(this).prop('checked');

            // Mettre à jour la visibilité du nœud en fonction de l'état de la case à cocher
            if (isChecked) {
                // Afficher le nœud
                // Vous pouvez remplacer cette ligne par le code nécessaire pour afficher le nœud
                console.log('Afficher le nœud avec ID ' + nodeId);
            } else {
                // Masquer le nœud
                // Vous pouvez remplacer cette ligne par le code nécessaire pour masquer le nœud
                console.log('Masquer le nœud avec ID ' + nodeId);
            }
        });
    }
});
