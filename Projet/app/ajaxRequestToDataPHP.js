document.addEventListener('DOMContentLoaded', (event) => {
    // Store the paths to your images
    const images = {
        'firstLayer': 'Images/map.png',
        'secondLayer': 'Images/google-map.png',
        'thirdLayer': 'Images/google-map1.png',
        'default': 'Images/blank.png'
    };

    function changeImage() {
        let selectedLayer;
        if(document.getElementById('firstLayer').checked) {
            selectedLayer = 'firstLayer';
        } else if(document.getElementById('secondLayer').checked) {
            selectedLayer = 'secondLayer';
        } else if(document.getElementById('thirdLayer').checked) {
            selectedLayer = 'thirdLayer';
        } else {
            selectedLayer = 'default'; // Set to 'default' if no checkbox is selected
        }

        // Update the image source directly
        const img = document.getElementById('map-image');
        img.src = images[selectedLayer];
    }

    // Attach an onchange event listener to each checkbox that calls the function when the checkbox is checked or unchecked.
    console.log(document.getElementById('firstLayer'));
    document.getElementById('firstLayer').onchange = changeImage;
    console.log(document.getElementById('secondLayer'));
    document.getElementById('secondLayer').onchange = changeImage;
    console.log(document.getElementById('thirdLayer'));
    if(document.getElementById('thirdLayer') === null) {
        console.error('Element with id "thirdLayer" not found');
    } else {
        document.getElementById('thirdLayer').onchange = changeImage;
    }
});