<?php
function mota_enqueue_styles() {
    wp_enqueue_style('mota-style', get_stylesheet_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');

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
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        wp_reset_postdata();

        if ($image_url) {
            return rest_ensure_response(['image_url' => $image_url]);
        }
    }

    return rest_ensure_response(['image_url' => '']);
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/random-photo', [
        'methods'  => 'GET',
        'callback' => 'get_random_featured_photo',
    ]);
});



/****** chargement AJAX */
function get_photo_query_params($paged = 1, $category_filter = '') {
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 6, 
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'ASC',
    );

    // Si une catégorie est sélectionnée, ajoute un filtre par taxonomie
    if ($category_filter) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie', // Assurez-vous que c'est le bon nom de taxonomie
                'field'    => 'term_id',
                'terms'    => $category_filter,
                'operator' => 'IN',
            ),
        );
    }

    return $args;
}

function load_more_photos() {
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'load_more_nonce')) {
        die('Permission denied');
    }

    $paged = isset($_GET['page']) ? $_GET['page'] : 1;
    $category_filter = isset($_GET['category_filter']) ? $_GET['category_filter'] : ''; // Récupère la catégorie filtrée
    $args = get_photo_query_params($paged, $category_filter); // Passe la catégorie dans les paramètres
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        include('parts/photo_block.php');
    else :
        echo ''; // Aucune photo
    endif;
    die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos'); 
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
