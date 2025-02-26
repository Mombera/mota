<?php
function mota_enqueue_styles() {
    wp_enqueue_style('mota-style', get_stylesheet_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');

//* LOGO*//
function mota_theme_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 100,  
        'width'       => 300,  
        'flex-height' => true, 
        'flex-width'  => true, 
    ));
}
add_action('after_setup_theme', 'mota_theme_setup');


function theme_enqueue_scripts() {
    wp_enqueue_script(
        'header-script', 
        get_stylesheet_directory_uri() . '/js/header.js', 
        null,
        true
    );
    wp_localize_script('header-script', 'themeData', array(
        'themeUrl' => get_stylesheet_directory_uri()
    ));
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


