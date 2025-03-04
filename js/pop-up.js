
     document.addEventListener("DOMContentLoaded", function() {
        var popup = document.getElementById("popup");
        var popupClose = document.getElementById("popup-close");
        const contactBtn = document.querySelector('.menu-item-23');
        const cta = document.querySelector('.cta');
    

        popupClose.addEventListener("click", function() {
            popup.style.display = "none"; 
        });

        window.addEventListener("click", function(event) {
            if (event.target === popup) {
                popup.style.display = "none"; 
            }
        });
        if (contactBtn && popup) {
            contactBtn.addEventListener('click', function () {
                popup.style.display = 'flex';
            })};
        if (cta && popup) {
            cta.addEventListener('click', function () {
                popup.style.display = 'flex';
                const refInput = document.querySelector('input[name="photo"]');
                const photoRef = document.querySelector('.single-ref');
                const photoRefSplit = photoRef.innerText.split(': ')[1];
                refInput.value = photoRefSplit;
            })};
    });
