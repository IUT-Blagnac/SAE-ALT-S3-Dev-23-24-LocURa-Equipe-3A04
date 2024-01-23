function filterNodes() {
    var input = document.getElementById('searchInput');
    var filter = input.value.toUpperCase();
    var nodeContainers = document.querySelectorAll('.node-container');

    var anyContainerDisplayed = false;

    nodeContainers.forEach(function(container) {
        var nodeText = container.textContent || container.innerText;

        if (nodeText.toUpperCase().indexOf(filter) > -1) {
            container.style.display = '';  // Afficher le conteneur du nœud
            anyContainerDisplayed = true;
        } else {
            container.style.display = 'none';  // Masquer le conteneur du nœud
        }
    });

    // Afficher ou masquer le dropdown en fonction des résultats de la recherche
    var dropdown = document.getElementById('nodes');

    if (!anyContainerDisplayed) {
        dropdown.innerHTML = '<br><option>Aucun point avec cette id</option>';  // Afficher le message d'aucun résultat
    } 
}function filterNodes() {
    var input = document.getElementById('searchInput');
    var filter = input.value.toUpperCase();
    var nodeContainers = document.querySelectorAll('.node-container');

    var anyContainerDisplayed = false;

    nodeContainers.forEach(function(container) {
        var nodeText = container.textContent || container.innerText;

        if (nodeText.toUpperCase().indexOf(filter) > -1) {
            container.style.display = '';  // Afficher le conteneur du nœud
            anyContainerDisplayed = true;
        } else {
            container.style.display = 'none';  // Masquer le conteneur du nœud
        }
    });

    // Afficher ou masquer le dropdown en fonction des résultats de la recherche
    var dropdown = document.getElementById('nodes');
    var noResultOption = document.getElementById('noResultOption');

    if (anyContainerDisplayed) {
        dropdown.style.display = 'block';  // Afficher le dropdown
        if (noResultOption) {
            dropdown.removeChild(noResultOption);  // Supprimer l'option "Aucun point avec cette id" si elle existe
        }
    } else {
        dropdown.style.display = 'block';  // Afficher le dropdown
        if (!noResultOption) {
            // Ajouter l'option "Aucun point avec cette id" si elle n'existe pas encore
            noResultOption = document.createElement('option');
            noResultOption.id = 'noResultOption';
            noResultOption.text = 'Aucun point avec cette id';
            console.log(noResultOption);
            
            dropdown.appendChild(noResultOption);
        }
    }
}

