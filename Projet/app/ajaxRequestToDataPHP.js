document.addEventListener('DOMContentLoaded', (event) => {
    const images = {
        'premierEtage': 'Images/map.png',
        'deuxiemeEtage': 'Images/google.png',
        'troisiemeEtage': 'Images/google1.png'
    };

    function changeImage() {
        const container = document.getElementById('map-container');
        container.innerHTML = ''; // Clear the container

        // Check each layer and add it to the container if it's selected
        for (let layer in images) {
            if (document.getElementById(layer) && document.getElementById(layer).checked) {
                const img = document.createElement('img');
                img.src = images[layer];
                img.className = 'map-container';
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