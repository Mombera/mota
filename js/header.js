document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.getElementById('menu');
    const icon = document.querySelector('.hamburger-icon');
    const menuItems = document.querySelectorAll(".menu li");

    menuToggle.addEventListener('click', function() {
        if (menu.classList.contains('open')) {
            menu.classList.add('close');
            icon.src = themeData.themeUrl + '/assets/hamburger.png';
            setTimeout(() => {
                menu.classList.remove('open');
            }, 500);
            
        } else {
            menu.classList.remove('close');
            menu.classList.add('open');
            icon.src = themeData.themeUrl + '/assets/openhamburger.png';
        }
    });
    
    menuItems.forEach(menuItem => {
        menuItem.classList.add('titleSlideIn');
        menuItem.addEventListener("click", () => {
            menu.classList.add('close');
            icon.src = themeData.themeUrl + '/assets/hamburger.png';
            setTimeout(() => {
                menu.classList.remove('open');
            }, 500);
        });
    });
});

