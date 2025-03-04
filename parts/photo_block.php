<?php
$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        if (has_post_thumbnail()) :
?>
            <div class="image-preview">
                <div class="inner">
                    <?php 
                        $large_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); 
                        $full_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    ?>
                    <img class="post-thumbnail" src="<?php echo esc_url($large_url); ?>" data-full="<?php echo esc_url($full_url); ?>" alt="Image preview">
                    <div class="overlayer">
                        <p class="post-ref"> <?php echo get_post_field('reference', get_the_ID()); ?></p>
                        <?php $post_categorie = get_the_terms(get_the_ID(), 'categorie'); ?>
                        <p class="post-cat"> <?php echo !empty($post_categorie) ? esc_html($post_categorie[0]->name) : ''; ?></p>
                        <a href="<?php the_permalink(); ?>">
                            <img class="icon eye" src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/eye.png" alt="Eye" />
                        </a>
                        <img class="icon fullscreen" src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/fullscreen.svg" alt="Full screen" />
                    </div>
                </div>
            </div>
<?php
        endif;
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>Aucune image disponible.</p>';
endif;
?>
