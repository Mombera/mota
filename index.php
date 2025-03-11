<?php get_header(); ?> 

<div class="hero-section">
    <h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/PHOTOGRAPHEEVENT.svg" alt="Photographe Event"></h1>
</div>

<div class="container photo-post no-border">
    <div class="apercu main-page">
        <div class="filter-container">
            <!-- Conteneur des filtres -->
            <div class="filters">
                <!-- Catégories -->
                <div class="filter one">
                    <div id="category-filter-custom" class="filter-custom">
                        <div class="icon-cont"><p>Catégories</p><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icon.png" class="down-arrow" alt="Icon"></div>
                        <ul id="category-filter-options" class="filter-options">
                            <li data-value="0">Catégories</li>
                            <?php
                            // Afficher les catégories dynamiquement ici
                            $categories = get_terms(array(
                                'taxonomy' => 'categorie',
                                'hide_empty' => true,
                            ));
                            if ($categories) :
                                foreach ($categories as $category) :
                                    echo '<li data-value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</li>';
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <input type="hidden" id="category-filter" name="category_filter" value="">
                </div>

                <div class="filter two">
                    <div id="format-filter-custom" class="filter-custom">
                    <div class="icon-cont"><p>Formats</p><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icon.png" class="down-arrow" alt="Icon"></div>
                        <ul id="format-filter-options" class="filter-options">
                            <li data-value="0">Formats</li>
                            <?php
                            $formats = get_terms(array(
                                'taxonomy' => 'format',
                                'hide_empty' => true,
                            ));
                            if ($formats) :
                                foreach ($formats as $format) :
                                    echo '<li data-value="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</li>';
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <input type="hidden" id="format-filter" name="format_filter" value="">
                </div>

                <!-- Trier par date -->
                <input type="hidden" id="date-sort" name="date_sort" value="rand">
            </div>
            <div class="filter three">
                <div id="date-sort-custom" class="filter-custom">
                <div class="icon-cont"><p>Trier par</p><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icon.png" class="down-arrow" alt="Icon"></div>
                    <ul id="date-sort-options" class="filter-options">
                        <li data-value="rand">Trier par</li>
                        <li data-value="desc">Du plus récent au plus ancien</li>
                        <li data-value="asc">Du plus ancien au plus récent</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="preview-container">
            <?php
            // Récupérer les filtres actuels
            $category_filter = isset($_GET['category_filter']) ? sanitize_text_field($_GET['category_filter']) : '';
            $format_filter = isset($_GET['format_filter']) ? sanitize_text_field($_GET['format_filter']) : '';
            $date_sort = isset($_GET['date_sort']) ? sanitize_text_field($_GET['date_sort']) : '';
            // Récupérer la page actuelle (si existe)
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            // Obtenir les arguments pour la requête
            $args = get_photo_query_params($paged, $category_filter, $format_filter, $date_sort);

            // Exécuter la requête et afficher les photos
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                include('parts/photo_block.php');
            else :
                echo '<p>Aucune photo trouvée.</p>';
            endif;

            wp_reset_postdata();
            ?>
        </div>
    </div>

    <button id="load-more-btn" data-nonce="<?php echo wp_create_nonce('load_more_nonce'); ?>">Charger plus</button>
</div>

<?php include('parts/lightbox.php'); ?>
<?php get_footer(); ?>
