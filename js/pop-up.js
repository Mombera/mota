jQuery(document).ready(function($) {
    var $popup = $('#popup');

    $('#popup-close, #popup').on('click', function (event) {
        if (event.target === this) $popup.hide();
    });

    $('.menu-item-23, .cta').on('click', function () {
        $popup.css('display', 'flex');
    });

    $('.cta').on('click', function () {
        let photoRefSplit = $('.single-ref').text().split(': ')[1];
        $('input[name="photo"]').val(photoRefSplit);
    });
});
