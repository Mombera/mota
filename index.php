<?php
get_header();
$hero_image = get_theme_mod('hero_image');?> 
<div class="hero-section" style="background-image: url('<?php echo esc_url($hero_image); ?>');"> 
    <h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/PHOTOGRAPHEEVENT.svg" alt="Photographe Event"></h1>
</div>
<? get_footer();