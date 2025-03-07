jQuery(document).ready(function($) {
    const $lightbox = $('#lightbox');
    const $lightboxImage = $('#lightbox-image');
    const $lightboxRef = $('.ref');
    const $lightboxCat = $('.categorie');
    const $suivant = $('.suivante');
    const $precedente = $('.precedente');
    
    let images = [];
    let currentIndex = 0;
    window.initializeLightbox = function() {
        $(".icon.fullscreen").each(function(index) {
            $(this).on("click", function() {
                const $inner = $(this).closest(".inner");
                images = $(".post-thumbnail").toArray();
                currentIndex = images.indexOf($inner.find(".post-thumbnail")[0]);
                updateLightbox(currentIndex);
            });
        });
    }

    function updateLightbox(index) {
        if (images.length > 0) {
            if (index < 0) {
                index = images.length - 1;
            } else if (index >= images.length) {
                index = 0;
            }
            currentIndex = index;
            const $image = $(images[currentIndex]);
            const fullSizeSrc = $image.data("full");
            const ref = $image.closest('.inner').find(".post-ref").text();
            const cat = $image.closest('.inner').find(".post-cat").text();

            $lightboxImage.attr("src", fullSizeSrc);
            $lightboxRef.text(ref);
            $lightboxCat.text(cat);
            $lightbox.addClass("active");
        }
    }

    $suivant.on("click", function() {
        updateLightbox(currentIndex + 1);
    });

    $precedente.on("click", function() {
        updateLightbox(currentIndex - 1);
    });

    $lightbox.on("click", function(event) {
        if (!$(event.target).is($lightboxImage) && !$(event.target).closest('.suivante').length && !$(event.target).closest('.precedente').length) {
            $lightbox.removeClass("active");
        }
    });
    initializeLightbox();
});