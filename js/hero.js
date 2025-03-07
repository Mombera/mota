jQuery(document).ready(function($) {
    $.ajax({
        url: '/wp-json/custom/v1/random-photo',
        method: 'GET',
        success: function(data) {
            if (data.image_url) {
                $('.hero-section').css('background-image', `url('${data.image_url}')`);
            }
        }
    });
});
