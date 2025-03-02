<?php get_header(); 

$photoTitle = get_the_title();
$date = get_the_date('Y');
$photo_id = get_post_thumbnail_id();  // Récupère l'ID de l'image en vedette

// Récupère les différentes tailles d'image
$photo_large = wp_get_attachment_image_url($photo_id, 'large');  // Taille large
$photo_medium = wp_get_attachment_image_url($photo_id, 'medium');  // Taille medium
$photo_thumbnail = wp_get_attachment_image_url($photo_id, 'thumbnail'); // Taille miniature
$ref = get_post_field('reference', get_the_ID());
$type = get_post_field('type', get_the_ID());
$format = get_the_terms(get_the_ID(), 'format');
$categorie = get_the_terms(get_the_ID(), 'categorie');
$category_id = !empty($categorie) ? $categorie[0]->term_id : null;
$args = array(
    'post_type'      => 'photo',
    'posts_per_page' => 5, 
    'post__not_in'   => array(get_the_ID()),
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => array(
        array(
            'taxonomy' => 'categorie',  // Remplace par le slug exact de ta taxonomie
            'field'    => 'term_id',
            'terms'    => $category_id,
        ),
    ),
);


$query = new WP_Query($args);

?>
<div class="container">
    <div class="photo-content <?php echo $format[0]->name; ?>">
        <div class="text-container">
            <h1><?php echo $photoTitle; ?></h1>
            <p>Réference : <?php echo $ref; ?></p>
            <p>Catégorie : <?php echo $categorie[0]->name; ?> </p>
            <p>Format : <?php echo $format[0]->name; ?></p>
            <p>Type : <?php echo $type; ?></p>
            <p>Date : <?php echo $date; ?> </p>
        </div>
        <div class="photo-container">
            <img src="<?php echo $photo_large; ?>" 
                srcset="<?php echo $photo_medium; ?> 468w, <?php echo $photo_large; ?> 1200w" 
                sizes="(max-width: 768px) 100vw, 800px" 
                alt="Photo de l'article">
        </div>
    </div>
    <div class="sub-section">
        <div class="cta-container">
            <p>Cette photo vous intéresse ?</p>
            <button>Contact</button>
        </div>
        <div class="apercu">
            <?php if ($query->have_posts()) : ?>
            <ul>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <h3><?php the_title(); ?></h3>
                            <?php the_post_thumbnail('thumbnail'); ?> 
                        </a>
                <?php endwhile; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
