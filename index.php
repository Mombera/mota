<?php
get_header(); ?> 
<div class="hero-section"> 
    <h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/PHOTOGRAPHEEVENT.svg" alt="Photographe Event"></h1>
</div>
<div class="container photo-post no-border">
    <div class="apercu main-page">
        <div class="filter-container">
            <!-- Conteneur des filtres -->
            <div class="filters">
                <!-- Sélecteur des catégories -->
                <div class="filter1">
                    <select id="category-filter" name="category-filter">
                        <option class="filtres" value="0">Catégories</option>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'categorie',
                            'hide_empty' => true,
                        ));
                        if ($categories) {
                            foreach ($categories as $category) {
                                echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Sélecteur des formats -->
                <div class="filter2">
                    <select id="format-filter" name="format-filter">
                        <option class="filtres" value="0">Format</option>
                        <?php
                        $formats = get_terms(array(
                            'taxonomy' => 'format', 
                            'hide_empty' => true,
                        ));
                        if ($formats) {
                            foreach ($formats as $format) {
                                echo '<option value="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="filter3">
                    <select id="date-sort" name="date-sort">
                        <option class="filtres" value="rand">trier par</option>
                        <option class="filtres" value="desc">Du plus récent au plus ancien</option>
                        <option class="filtres" value="asc">Du plus ancien au plus récent</option>
                    </select>
                </div>
            </div>

            <div class="sort">
            </div>
        </div>

        <div class="preview-container">
    <?php
        // Récupérer les filtres actuels
        $category_filter = isset($_GET['category_filter']) ? sanitize_text_field($_GET['category_filter']) : '';
        $format_filter = isset($_GET['format_filter']) ? sanitize_text_field($_GET['format_filter']) : '';
        $date_sort = isset($_GET['date_sort']) ? sanitize_text_field($_GET['date_sort']) : 'rand';
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
<?php include('parts/lightbox.php');
get_footer(); ?>