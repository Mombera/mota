<?php get_header(); 

$photoTitle = get_the_title();
$date = get_the_date('Y');
$photo_id = get_post_thumbnail_id(); 
$photo_full = wp_get_attachment_image_url($photo_id, 'large');  
$photo_medium = wp_get_attachment_image_url($photo_id, 'medium');  
$photo_thumbnail = wp_get_attachment_image_url($photo_id, 'thumbnail'); 
$ref = get_post_field('reference', get_the_ID());
$type = get_post_field('type', get_the_ID());
$format = get_the_terms(get_the_ID(), 'format');
$categorie = get_the_terms(get_the_ID(), 'categorie');
$prev_post = get_previous_post(false);
$next_post = get_next_post(false);
?>
<div class="container photo-post <?php echo $format[0]->name; ?>">
    <div class="photo-content">
        <div class="text-container">
            <div class="textC">
                <h1><?php echo $photoTitle; ?></h1>
                <p class="single-ref">Réference : <?php echo $ref; ?></p>
                <p>Catégorie : <?php echo $categorie[0]->name; ?> </p>
                <p>Format : <?php echo $format[0]->name; ?></p>
                <p>Type : <?php echo $type; ?></p>
                <p>Date : <?php echo $date; ?> </p>
            </div>
        </div>
        <div class="photo-container">
            <img src="<?php echo $photo_full; ?>" 
                srcset="<?php echo $photo_medium; ?> 468w, <?php echo $photo_full; ?> 1200w" 
                sizes="(max-width: 768px) 100vw, 800px" 
                alt="Photo de l'article">
        </div>
    </div>
</div>
<div class="container photo-post sub-section <?php echo $format[0]->name; ?>">
    <div class="fixer">
        <div class="cta-container">
            <p>Cette photo vous intéresse ?</p>
            <button class="cta">Contact</button>
        </div>
        <div class="suggestion-container">
            <ul><?php 
                if ($prev_post) : ?>
                <li>
                    <a href="<?php echo get_permalink($prev_post); ?>">
                        <div class="nav-image gauche">
                            <?php echo get_the_post_thumbnail($prev_post, 'thumbnail'); ?>
                            <img class="fleche" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/precedent black.svg" alt="Précédent">
                        </div>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($next_post) : ?>
                <li>
                    <a href="<?php echo get_permalink($next_post); ?>">
                        <div class="nav-image droite">
                            <?php echo get_the_post_thumbnail($next_post, 'thumbnail'); ?>
                            <img class="fleche" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/suivant black.svg" alt="Suivant">            
                        </div>
                    </a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<div class="container photo-post no-border">
    <div class="apercu">
        <h3>Vous aimerez aussi</h3>
        <div class="preview-container">
            <?php
                if (!empty($categorie)) {
                    $category_id = $categorie[0]->term_id;
                    $args = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categorie',
                                'field'    => 'id',
                                'terms'    => $category_id,
                                'operator' => 'IN',
                            ),
                        ),
                        'posts_per_page' => 2,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand',
                    );
                    include('parts/photo_block.php'); 
                }
            ?>
        </div>
    </div>
</div>

<? include('parts/lightbox.php');
 get_footer(); ?>
