<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="header" role="banner">
    <div class="inner-header">
        <?php
        if (function_exists('the_custom_logo') && has_custom_logo()) {
            the_custom_logo();
        } ?>
        <div class="menu-toggle" aria-label="Ouvrir le menu">
            <img class="hamburger-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/hamburger.png" alt="Menu" />
        </div>
        <nav id="menu" class="fadeIn">
            <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
        </nav>
    </div>
</header>
