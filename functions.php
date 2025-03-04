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
/****HERO ****/
function theme_customize_register($wp_customize) {
    $wp_customize->add_section('hero_section', array(
        'title' => __('Image Hero', 'mon-theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image_control', array(
        'label' => __('Choisissez une image Hero', 'mon-theme'),
        'section' => 'hero_section',
        'settings' => 'hero_image',
    )));
}
add_action('customize_register', 'theme_customize_register');



function my_custom_image_sizes() {
    update_option( 'medium_size_w', 400 );
    update_option( 'medium_size_h', 0 ); 
}
add_action('after_setup_theme', 'my_custom_image_sizes');


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
    wp_enqueue_script(
        'lightbox-script', 
        get_stylesheet_directory_uri() . '/js/lightbox.js', 
        null,
        true
    );
    wp_localize_script('header-script', 'themeData', array(
        'themeUrl' => get_stylesheet_directory_uri()
    ));
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


