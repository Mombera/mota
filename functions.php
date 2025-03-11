<?php
function mota_enqueue_styles() {
    wp_enqueue_style('mota-style', get_stylesheet_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');
function add_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null, 'all');
}
add_action('wp_enqueue_scripts', 'add_font_awesome');

//* LOGO et menu*//
function mota_theme_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 100,  
        'width'       => 300,  
        'flex-height' => true, 
        'flex-width'  => true, 
    ));

    register_nav_menu('footer', __('Menu Footer'));
}
add_action('after_setup_theme', 'mota_theme_setup');

function my_custom_image_sizes() {
    update_option( 'medium_size_w', 400 );
    update_option( 'medium_size_h', 0 ); 
}
add_action('after_setup_theme', 'my_custom_image_sizes');


function theme_enqueue_scripts() {

    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'header-script', 
        get_stylesheet_directory_uri() . '/js/header.js', 
        array('jquery'),  
        null,
        true  
    );  
    wp_enqueue_script(
        'pop-up-script', 
        get_stylesheet_directory_uri() . '/js/pop-up.js', 
        array('jquery'),  
        null,
        true  
    );
    wp_enqueue_script(
        'lightbox-script', 
        get_stylesheet_directory_uri() . '/js/lightbox.js', 
        array('jquery'),  
        null,
        true  
    );
    
    if (is_home()) {
    wp_enqueue_script(
        'hero-script', 
        get_stylesheet_directory_uri() . '/js/hero.js', 
        array('jquery'),  
        null,
        false  
    );}
    wp_enqueue_script(
        'load-more-script',
        get_stylesheet_directory_uri() . '/js/load-more.js',
        array('jquery'),
        null,
        true
    );
    wp_localize_script('load-more-script', 'themeData', array(
        'themeUrl'   => get_stylesheet_directory_uri(),
        'ajax_url'   => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('load_more_nonce')
    ));
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');



/*** HERO  ***/
function get_random_featured_photo() {
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 1,
        'orderby'        => 'rand',
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();

        // Récupérer les URL des images dans différentes tailles
        $full_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $large_image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        wp_reset_postdata();

        if ($full_image_url && $large_image_url) {
            return rest_ensure_response([
                'image_url' => $full_image_url,         // URL de l'image en taille pleine
                'large_image_url' => $large_image_url // URL de l'image en taille moyenne
            ]);
        }
    }

    return rest_ensure_response(['image_url' => '', 'large_image_url' => '']);
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/random-photo', [
        'methods'  => 'GET',
        'callback' => 'get_random_featured_photo',
    ]);
});




/****** chargement AJAX */
function get_photo_query_params($paged = 1, $category_filter = '', $format_filter = '', $date_sort = '') {
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => $date_sort,  // Tri dynamique selon la valeur du filtre
        'tax_query'      => array('relation' => 'AND'),
    );
    if ($date_sort === 'asc') {
        $args['order'] = 'ASC';
    } elseif ($date_sort === 'desc') {
        $args['order'] = 'DESC';
    } else {
        $args['orderby'] = 'title';
        $args['order'] = 'ASC'; // Utilisation du tri aléatoire
    }
    if (!empty($category_filter)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $category_filter,
        );
    }

    if (!empty($format_filter)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'term_id',
            'terms'    => $format_filter,
        );
    }

    return $args;
}


function load_more_photos() {
    // Sécuriser l'accès avec le nonce
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'load_more_nonce')) {
        die('Permission denied');
    }

    // Récupérer les paramètres de la page, du filtre catégorie et du filtre format
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $category_filter = isset($_GET['category_filter']) ? sanitize_text_field($_GET['category_filter']) : '';
    $format_filter = isset($_GET['format_filter']) ? sanitize_text_field($_GET['format_filter']) : '';
    $date_sort = isset($_GET['date_sort']) ? sanitize_text_field($_GET['date_sort']) : '';  // Récupérer le paramètre de tri

    // Préparer la requête avec les filtres et le tri
    $args = get_photo_query_params($paged, $category_filter, $format_filter, $date_sort);
    

    // Déboguer si nécessaire
    // error_log(print_r($args, true));

    // Exécuter la requête WP
    $query = new WP_Query($args);

    // Vérifier si des posts sont trouvés
    if ($query->have_posts()) :
        include('parts/photo_block.php'); // Inclure le rendu des photos
    else :
        echo ''; // Aucun résultat
    endif;

    // Terminer la requête AJAX
    wp_die();
}

// Enregistrer l'action AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
