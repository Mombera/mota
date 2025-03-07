jQuery(document).ready(function($) {
    var page = 1;
    var loading = false;
    var load_more_nonce = themeData.nonce;

    // Créer la structure personnalisée de sélection pour "catégories"
    var $filterCustomContainer1 = $('.filter1');
    var $filterCustomContainer2 = $('.filter2');
    var $customFilter = $('<div>', { id: 'category-filter-custom' }).text('Catégories');
    var $customOptions = $('<div>', { id: 'category-filter-options' });

    // Remplir la liste des options personnalisées à partir de <option> dans #category-filter
    $('#category-filter option').each(function() {
        var $option = $(this);
        if ($option.val()) {
            var $optionDiv = $('<div>', { 'data-value': $option.val() }).text($option.text());
            $customOptions.append($optionDiv);
        }
    });

    // Créer la structure personnalisée de sélection pour "format"
    var $customFormatFilter = $('<div>', { id: 'format-filter-custom' }).text('Format');
    var $customFormatOptions = $('<div>', { id: 'format-filter-options' });

    $('#format-filter option').each(function() {
        var $option = $(this);
        if ($option.val()) {
            var $optionDiv = $('<div>', { 'data-value': $option.val() }).text($option.text());
            $customFormatOptions.append($optionDiv);
        }
    });

    // Ajouter les deux filtres dans la page
    $filterCustomContainer1.append($customFilter, $customOptions);
    $filterCustomContainer2.append($customFormatFilter, $customFormatOptions);

    // Utilisation de la délégation pour les événements de clic
    $(document).on('click', '#category-filter-custom', function() {
        $(this).toggleClass('active');
        $('#category-filter-options').toggle();
    });

    $(document).on('click', '#format-filter-custom', function() {
        $(this).toggleClass('active');
        $('#format-filter-options').toggle();
    });

    // Gérer le clic sur une option dans les filtres (Catégories)
    $(document).on('click', '#category-filter-options div', function() {
        var selectedValue = $(this).data('value');
        $('#category-filter').val(selectedValue);
        $('#category-filter-custom').text($(this).text());
        $('#category-filter-options').hide();
        $('#category-filter-custom').toggleClass('active');
        filterPhotos();  // Appliquer le filtrage des photos après la sélection de la catégorie
    });

    // Gérer le clic sur une option dans les filtres (Format)
    $(document).on('click', '#format-filter-options div', function() {
        var selectedValue = $(this).data('value');
        $('#format-filter').val(selectedValue);
        $('#format-filter-custom').text($(this).text());  // Mettre à jour le texte du filtre "Format"
        $('#format-filter-options').hide();
        $('#format-filter-custom').toggleClass('active');
        filterPhotos();  // Appliquer le filtrage des photos après la sélection du format
    });

    // Gérer le clic sur une option dans le tri par date
    $(document).on('change', '#date-sort', function() {
        filterPhotos();  // Appliquer le tri après le changement
    });

    // Fonction générique pour charger les photos
    function loadPhotos(categoryFilter, formatFilter, dateSort) {
        var data = {
            action: 'load_more_photos',
            page: page,
            nonce: load_more_nonce,
            category_filter: categoryFilter,
            format_filter: formatFilter,
            date_sort: dateSort  // On envoie le paramètre du tri à AJAX
        };

        console.log("Chargement des photos avec les filtres suivants :");
        console.log("Catégorie : " + categoryFilter);
        console.log("Format : " + formatFilter);
        console.log("Tri : " + dateSort);  // Affiche le tri dans la console
        console.log("Données envoyées à AJAX :", data);

        $.ajax({
            url: themeData.ajax_url,
            type: 'GET',
            data: data,
            success: function(response) {
                console.log("Réponse Ajax : ", response);
                if (response) {
                    if (page === 1) {
                        $('.photo-post .preview-container').html(response); // Mettre à jour uniquement la première page
                    } else {
                        $('.photo-post .preview-container').append(response); // Ajouter plus de photos
                    }

                    loading = false;
                    initializeLightbox();  // Réinitialiser le lightbox si nécessaire
                    $('#load-more-btn').text('Charger plus');
                } else {
                    // Aucun résultat trouvé
                    if (page === 1) {
                        $('.photo-post .preview-container').html('<p>Aucune photo trouvée pour les filtres sélectionnés.</p>');
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

    // Fonction de filtrage avec les deux filtres et le tri
    function filterPhotos() {
        var categoryFilter = $('#category-filter').val();
        var formatFilter = $('#format-filter').val();
        var dateSort = $('#date-sort').val();  // On récupère maintenant la valeur du tri

        // Si "Aucun filtre" est sélectionné, envoyer une chaîne vide
        if (categoryFilter === '0') categoryFilter = '';
        if (formatFilter === '0') formatFilter = '';

        page = 1;  // Remettre la page à 1 pour charger les résultats filtrés
        loadPhotos(categoryFilter, formatFilter, dateSort);  // Charger les photos avec les filtres et le tri
    }

    // Changement de filtre dans le select
    $('#category-filter, #format-filter').change(function() {
        $('#load-more-btn').text('Charger plus');
        filterPhotos();  // Appliquer les filtres
    });

    // Clic sur le bouton "Charger plus"
    $('#load-more-btn').click(function() {
        if (loading) return;
        loading = true;
        page++;
        var categoryFilter = $('#category-filter').val();
        var formatFilter = $('#format-filter').val();
        var dateSort = $('#date-sort').val();  // On récupère la valeur du tri

        // Si "Aucun filtre" est sélectionné, envoyer une chaîne vide
        if (categoryFilter === '0') categoryFilter = '';
        if (formatFilter === '0') formatFilter = '';

        loadPhotos(categoryFilter, formatFilter, dateSort);  // Charger les photos avec les filtres
    });
});
