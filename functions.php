<?php
function mota_enqueue_styles() {
    wp_enqueue_style('mota-style', get_stylesheet_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');

//* LOGO*//
// Fonction pour ajouter les fonctionnalités du thème
function mota_theme_setup() {
    // Support du logo personnalisé
    add_theme_support('custom-logo', array(
        'height'      => 100,  
        'width'       => 300,  
        'flex-height' => true, 
        'flex-width'  => true, 
    ));

    // Enregistrement du menu footer
    register_nav_menu('footer', __('Menu Footer'));
}

// Ajouter les actions pour le setup du thème
add_action('after_setup_theme', 'mota_theme_setup');

// Fonction pour enregistrer les menus (ici footer)
function register_footer_menu() {
    // Enregistre un emplacement de menu pour le footer
    register_nav_menu('footer', __('Menu Footer'));
}

// Appeler la fonction d'enregistrement du menu footer
add_action('after_setup_theme', 'register_footer_menu');



function theme_enqueue_scripts() {
    wp_enqueue_script(
        'header-script', 
        get_stylesheet_directory_uri() . '/js/header.js', 
        null,
        true
    );
    wp_enqueue_script(
        'pop-up-script', 
        get_stylesheet_directory_uri() . '/js/pop-up.js', 
        null,
        true
    );
    wp_localize_script('header-script', 'themeData', array(
        'themeUrl' => get_stylesheet_directory_uri()
    ));
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


