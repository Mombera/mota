
     document.addEventListener("DOMContentLoaded", function() {
        var popup = document.getElementById("popup");
        var popupClose = document.getElementById("popup-close");

        popupClose.addEventListener("click", function() {
            popup.style.display = "none"; 
        });

        window.addEventListener("click", function(event) {
            if (event.target === popup) {
                popup.style.display = "none"; 
            }
        });
    });
