<footer id="footer" role="contentinfo">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer', 
            'container' => 'nav', 
            'container_class' => 'footer-menu', 
            'menu_class' => 'menuF', 
        ));
    ?>

        <div>TOUS DROITS RÉSERVÉS</div>
    </footer>
    <? include('parts/pop-up.php'); ?>
<?php wp_footer(); ?>
</body>
</html>