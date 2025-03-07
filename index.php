<?php
get_header();?> 
<div class="hero-section"> 
    <h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/PHOTOGRAPHEEVENT.svg" alt="Photographe Event"></h1>
</div>
<div class="container photo-post no-border">
    <div class="apercu main-page">
    <div class="filter-container">
        <div class="filters">
            <select id="category-filter" name="category-filter">
                <option class="filtres" value="">Catégories</option>
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
        <div class="sort">
        </div>
        </div>
        <div class="preview-container">
            <?php
             $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
             $args = get_photo_query_params($paged);
             include('parts/photo_block.php');?>
        </div>
    </div>
    <button id="load-more-btn" data-nonce="<?php echo wp_create_nonce('load_more_nonce'); ?>">Charger plus</button>
</div>
<? include('parts/lightbox.php');
 get_footer();