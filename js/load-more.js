jQuery(document).ready(function($) {
    var page = 1;
    var loading = false;
    var load_more_nonce = themeData.nonce;

    $('#load-more-btn').click(function() {
        if (loading) return; 
        loading = true;
        page++;
        var categoryFilter = $('#category-filter').val(); 
        var data = {
            action: 'load_more_photos',
            page: page,
            nonce: load_more_nonce,
            category_filter: categoryFilter 
        };

        $.ajax({
            url: themeData.ajax_url,  
            type: 'GET',
            data: data,
            success: function(response) {
                if (response) {
                    $('.photo-post .preview-container').append(response);
                    loading = false;

                    initializeLightbox();
                } else {
                    $('#load-more-btn').hide(); 
                }
            },
            error: function() {
                loading = false;
                alert("Erreur lors du chargement des photos.");
            }
        });
    });

/*** FILTRES */
    $('#category-filter').change(function() {
        page = 1;
        var categoryFilter = $(this).val(); 

        var data = {
            action: 'load_more_photos',
            page: page,
            nonce: load_more_nonce,
            category_filter: categoryFilter
        };

        $.ajax({
            url: themeData.ajax_url,
            type: 'GET',
            data: data,
            success: function(response) {
                if (response) {
                    $('.photo-post .preview-container').html(response); 
                    $('#load-more-btn').show(); 
                    loading = false;
                    initializeLightbox();
                }
            },
            error: function() {
                loading = false;
                alert("Erreur lors du chargement des photos.");
            }
        });
    });
});
