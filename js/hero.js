jQuery(document).ready(function($) {
    $.ajax({
        url: '/wp-json/custom/v1/random-photo',
        method: 'GET',
        success: function(data) {
            if (data.image_url) {
                // Détecter la largeur de l'écran
                var screenWidth = $(window).width();
                
                // Si l'écran est plus petit que 1000px, utiliser l'image en taille medium
                var imageUrl = (screenWidth < 1000) ? data.large_image_url : data.image_url;

                // Appliquer l'image comme background
                $('.hero-section').css('background-image', `url('${imageUrl}')`);
            }
        }
    });
});
