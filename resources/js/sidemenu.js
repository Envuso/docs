document.addEventListener('DOMContentLoaded', function () {
    const menuIcons = document.getElementsByClassName('hamburger');

    if (!menuIcons) {
        return;
    }

    Object.values(menuIcons).forEach(icon => {
        icon.addEventListener('click', toggleMenu);
    });

});

function toggleMenu()
{
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
