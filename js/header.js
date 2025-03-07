jQuery(document).ready(function($) {
    const $menuToggle = $('.menu-toggle');
    const $menu = $('#menu');
    const $icon = $('.hamburger-icon');
    const $menuItems = $(".menu li");

    $menuToggle.on('click', function() {
        if ($menu.hasClass('open')) {
            $menu.addClass('close');
            $icon.attr('src', themeData.themeUrl + '/assets/hamburger.png');
            setTimeout(function() {
                $menu.removeClass('open');
            }, 500);
        } else {
            $menu.removeClass('close');
            $menu.addClass('open');
            $icon.attr('src', themeData.themeUrl + '/assets/openhamburger.png');
        }
    });

    $menuItems.each(function() {
        $(this).addClass('titleSlideIn');
        $(this).on("click", function() {
            $menu.addClass('close');
            $icon.attr('src', themeData.themeUrl + '/assets/hamburger.png');
            setTimeout(function() {
                $menu.removeClass('open');
            }, 500);
        });
    });
});
