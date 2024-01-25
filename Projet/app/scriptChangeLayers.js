const images = {
    'premierEtage': 'Images/map.png',
    'deuxiemeEtage': 'Images/google.png',
    'troisiemeEtage': 'Images/google1.png'
};

// Change le z-index et l'opacité des images des étages qui est par-dessus les autres
function changeLayers(selectedLayer) {
    for (let layer in images) {
        if (document.getElementById(layer) && document.getElementById(layer).checked) {
            const element = document.getElementById(layer);

            if (layer === selectedLayer) {
                element.style.opacity = '0.5';
                element.style.zIndex = '10';
            } else {
                element.style.opacity = '1';
                element.style.zIndex = '0';
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    // Fonction pour changer l'opacité et le z-index d'une image
    function changeImageProperties(selectedImageId, zIndex, opacity) {
        const images = document.querySelectorAll('.map-container img');
        images.forEach((image) => {
            if (image.id === selectedImageId) {
                image.style.opacity = opacity;
                image.style.zIndex = zIndex;
            }
        });
    }

    // Ajout des écouteurs d'événements aux boutons
    document.getElementById('buttonEtage1').onclick = function() {
        changeImageProperties('imageEtage1', '999', '0.5');
    };

    document.getElementById('buttonEtage2').onclick = function() {
        changeImageProperties('imageEtage2', '999', '0.5');
    };

    document.getElementById('buttonEtage3').onclick = function() {
        changeImageProperties('imageEtage3', '999', '0.5');
    };

    function changeImage() {
        const container = document.getElementById('map-container');
        container.innerHTML = ''; // Clear the container

        // Check each layer and add it to the container if it's selected
        for (let layer in images) {
            if (document.getElementById(layer) && document.getElementById(layer).checked) {
                const img = document.createElement('img');
                img.src = images[layer];
                img.className = 'layer1';
                img.style.position = 'absolute';
                container.appendChild(img);
            }
        }
    }

    // Attach an onchange event listener to each checkbox
    document.getElementById('premierEtage').onchange = changeImage;
    document.getElementById('deuxiemeEtage').onchange = changeImage;
    document.getElementById('troisiemeEtage').onchange = changeImage;

    // Check if any checkboxes are checked at startup
    function checkCheckboxesAtStartup() {
        for (let layer in images) {
            if (document.getElementById(layer) && document.getElementById(layer).checked) {
                console.log(layer + " is checked at startup");
            }
        }
    }

    // Call the function to check checkboxes at startup
    checkCheckboxesAtStartup();

    // Set the checkbox with id="premierEtage" to checked by default
    document.getElementById('premierEtage').checked = true;

    // Call the changeImage function to display the image
    changeImage();
});