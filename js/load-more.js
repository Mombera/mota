jQuery(document).ready(function($) {
    var page = 1;
    var loading = false;
    var load_more_nonce = themeData.nonce;

    function checkFilterUsed() {
        $('#category-filter-custom p').text().trim() !== ('Catégories')
            ? $('#category-filter-custom').find('.icon-cont').addClass('used')
            : $('#category-filter-custom').find('.icon-cont').removeClass('used');
        
        $('#format-filter-custom p').text().trim() !== ('Formats')
            ? $('#format-filter-custom').find('.icon-cont').addClass('used')
            : $('#format-filter-custom').find('.icon-cont').removeClass('used');
        
        $('#date-sort-custom p').text().trim() !== ('Trier par')
            ? $('#date-sort-custom').find('.icon-cont').addClass('used')
            : $('#date-sort-custom').find('.icon-cont').removeClass('used');
    }
    
    $(document).on('click', '#category-filter-options li', function() {
        var selectedValue = $(this).data('value'); 
        $('#category-filter').val(selectedValue);
        $('#category-filter-custom p').text($(this).text());

        checkFilterUsed();
        filterPhotos();
    });
    
    $(document).on('click', '#format-filter-options li', function() {
        var selectedValue = $(this).data('value'); 
        $('#format-filter').val(selectedValue);
        $('#format-filter-custom p').text($(this).text());

        checkFilterUsed();
        filterPhotos();
    });

    $(document).on('click', '#date-sort-options li', function() {
        var selectedValue = $(this).data('value');
        $('#date-sort').val(selectedValue);
        $('#date-sort-custom p').text($(this).text());
        $('#date-sort-options').hide();

        checkFilterUsed();
        filterPhotos();
    });

    $(document).on('click', '#category-filter-custom, #format-filter-custom, #date-sort-custom', function() {
        $(this).toggleClass('active');
    });

    function loadPhotos(categoryFilter, formatFilter, dateSort) {
        var data = {
            action: 'load_more_photos',
            page: page,
            nonce: load_more_nonce,
            category_filter: categoryFilter,
            format_filter: formatFilter,
            date_sort: dateSort
        };

        $.ajax({
            url: themeData.ajax_url,
            type: 'GET',
            data: data,
            success: function(response) {
                if (response) {
                    if (page === 1) {
                        $('.photo-post .preview-container').html(response);
                    } else {
                        $('.photo-post .preview-container').append(response);
                    }

                    loading = false;
                    initializeLightbox();
                    $('#load-more-btn').text('Charger plus');
                } else {
                    if (page === 1) {
                        $('.photo-post .preview-container').html('<p>Aucune photo trouvée.</p>');
                    } else {
                        $('#load-more-btn').text('Aucune photo trouvée');
                    }
                    loading = false;
                }
            },
            error: function(xhr, status, error) {
                loading = false;
                console.error("Erreur lors du chargement des photos : ", error);
                alert("Erreur lors du chargement des photos.");
            }
        });
    }

    function filterPhotos() {
        var categoryFilter = $('#category-filter').val();
        var formatFilter = $('#format-filter').val();
        var dateSort = $('#date-sort').val();

        if (categoryFilter === '0') categoryFilter = '';
        if (formatFilter === '0') formatFilter = '';
        page = 1;
        loadPhotos(categoryFilter, formatFilter, dateSort);
    }

    $('#load-more-btn').click(function() {
        if (loading) return;
        loading = true;
        page++;
        var categoryFilter = $('#category-filter').val();
        var formatFilter = $('#format-filter').val();
        var dateSort = $('#date-sort').val();

        if (categoryFilter === '0') categoryFilter = '';
        if (formatFilter === '0') formatFilter = '';

        loadPhotos(categoryFilter, formatFilter, dateSort);
    });
});
