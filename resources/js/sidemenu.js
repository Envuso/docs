document.addEventListener('DOMContentLoaded', function () {
    const menuIcons = document.getElementsByClassName('hamburger');
    const sideMenu = document.getElementById('sideMenu');
    var dropdownID = document.getElementsByClassName('dropdown-toggle');
    if (!menuIcons) {
        return;
    }

    if (!menuIcons[0].classList.contains('hamburger-enabled')) {
        sideMenu.classList.toggle('hidden');
        sideMenu.classList.toggle('sm:flex');
        sideMenu.classList.toggle('bg-gray-700');
    }

    Object.values(menuIcons).forEach(icon => {
        icon.addEventListener('click', toggleMenu);
    });

    Array.from(dropdownID).forEach((element) => {
        element.addEventListener('click', (event) => {
            document.getElementById('dropdown-menu').classList.toggle("hidden");
            document.getElementById('dropdown-menu').classList.toggle("block");
        });
    });
});

function toggleMenu() {
    const sideMenu = document.getElementById('sideMenu');
    if (!sideMenu) {
        return;
    }

    sideMenu.classList.toggle('hidden');
    sideMenu.classList.toggle('sm:flex');
    sideMenu.classList.toggle('bg-gray-700');

    const menuIcons = document.getElementsByClassName('hamburger');
    Object.values(menuIcons).forEach(icon => {
        icon.classList.toggle('hamburger-enabled');
    });


}
