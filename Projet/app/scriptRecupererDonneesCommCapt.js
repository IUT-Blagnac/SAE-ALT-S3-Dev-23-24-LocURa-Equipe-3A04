document.addEventListener('DOMContentLoaded', function() {
    $ajax({
        url : 'donnes.php',
        method : 'post',
        dataType : 'json',
        data:{request:"getCommCapt"},
        success : function(data){
            console.log('Données récupérées avec succès');

        },
        error: function(error){
            console.error('Données non récupérées',error);
        }
    });
}); 
