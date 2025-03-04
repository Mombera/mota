<?php
get_header();
$hero_image = get_theme_mod('hero_image');?> 
<div class="hero-section" style="background-image: url('<?php echo esc_url($hero_image); ?>');"> 
    <h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/PHOTOGRAPHEEVENT.svg" alt="Photographe Event"></h1>
</div>
<div class="container photo-post no-border">
    <div class="apercu main-page">
        <h3>Photos populaires</h3>
        <div class="preview-container">
            <?php
                $args = array(
                    'post_type'      => 'photo',
                    'posts_per_page' => -1,
                );
             include('parts/photo_block.php');?>
        </div>
    </div>
</div>
<? include('parts/lightbox.php');
 get_footer();