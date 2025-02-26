<?php get_header(); ?>
<div class="entry-content" itemprop="mainContentOfPage">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
    <?php the_content(); ?>
    <div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
<?php get_footer(); ?>