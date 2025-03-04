document.addEventListener("DOMContentLoaded", function () {
    const lightbox = document.getElementById("lightbox");
    const lightboxImage = document.getElementById("lightbox-image");
    const lightboxRef = document.querySelector('.ref');
    const lightboxCat = document.querySelector('.categorie');
    const suivant = document.querySelector('.suivante');
    const precedente = document.querySelector('.precedente');
    
    let images = [];
    let currentIndex = 0;

    document.querySelectorAll(".icon.fullscreen").forEach((icon, index) => {
        icon.addEventListener("click", function () {
            const inner = this.closest(".inner");
            images = Array.from(document.querySelectorAll(".post-thumbnail"));
            currentIndex = images.indexOf(inner.querySelector(".post-thumbnail"));
            updateLightbox(currentIndex);
        });
    });

    function updateLightbox(index) {
        if (images.length > 0) {
            if (index < 0) {
                index = images.length - 1; 
            } else if (index >= images.length) {
                index = 0; 
            }
            currentIndex = index;
            const image = images[currentIndex];
            const fullSizeSrc = image.getAttribute("data-full");
            const ref = image.closest('.inner').querySelector(".post-ref").textContent;
            const cat = image.closest('.inner').querySelector(".post-cat").textContent;

            lightboxImage.src = fullSizeSrc;
            lightboxRef.textContent = ref;
            lightboxCat.textContent = cat;
            lightbox.classList.add("active");
        }
    }

    suivant.addEventListener("click", function () {
        updateLightbox(currentIndex + 1);
    });

    precedente.addEventListener("click", function () {
        updateLightbox(currentIndex - 1);
    });

    lightbox.addEventListener("click", function (event) {
        if (event.target !== lightboxImage && !event.target.closest('.suivante') && !event.target.closest('.precedente')) {
            lightbox.classList.remove("active");
        }
    });
});
