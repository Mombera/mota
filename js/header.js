document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.getElementById('menu');
    const icon = document.querySelector('.hamburger-icon');
    const menuItems = document.querySelectorAll(".menu li")

    if (!menuToggle || !menu || !icon) {
        return; // Arrête l'exécution si un élément est manquant
    }

    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('open');
        icon.src = menu.classList.contains('open') 
            ? themeData.themeUrl + '/assets/openhamburger.png' 
            : themeData.themeUrl + '/assets/hamburger.png';
        menu.style.display = menu.classList.contains('open') 
            ? "block" 
            : "none";
    });
    menuItems.forEach(menuItem => {
        menuItem.classList.add('titleSlideIn');
        menuItem.addEventListener("click", () => {
            menu.classList.remove('open'); 
            icon.src = themeData.themeUrl + '/assets/hamburger.png';
            menu.style.display = "none";
         });
    });
});
