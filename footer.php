<footer id="footer" role="contentinfo">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer', 
            'container' => 'nav', 
            'container_class' => 'footer-menu', 
            'menu_class' => 'menuF', 
        ));
    ?>

        TOUS DROITS RÉSERVÉS
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>