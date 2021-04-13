function toggleMenu() {
    var sideMenu = document.getElementById('sideMenu');
    var menuIcon = document.getElementById('menuIcon');
    if (sideMenu.id !== null) {
        sideMenu.classList.toggle('hidden');
        sideMenu.classList.toggle('bg-gray-700');
        menuIcon.classList.toggle('bg-gray-700');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var menuIcon = document.getElementById('menuIcon');
    if (menuIcon.id !== null) {
        menuIcon.addEventListener('click', toggleMenu);
    }
});
