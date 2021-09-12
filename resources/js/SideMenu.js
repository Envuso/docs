import { LocalStorage }                                                    from 'typesafe-local-storage';
import { createActiveGroupEventListener, setCurrentActiveGroupFromWindow } from './PageActiveGroup';
import { clearActiveMenuItems, closeActiveMenuItems }                      from './PageRouting';


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

function handleDropDown()
{
    const menuIcons = document.getElementsByClassName('hamburger');
    const sideMenu  = document.getElementById('sideMenu');
    var dropdownID  = document.getElementsByClassName('dropdown-toggle');
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
}

function closeOtherMenus()
{
    const dropdowns = document.getElementsByClassName("item-group-title");

    for (let dropdown of dropdowns) {
        if (dropdown.classList.contains('active')) {
            dropdown.click();
        }
    }
}

function handleSidebarItemDropdown()
{
    const dropdowns = document.getElementsByClassName("item-group-title");

    for (let dropdown of dropdowns) {
        dropdown.addEventListener("click", function () {
            closeOtherMenus();

            dropdown.classList.toggle('active');

            const dropdownLinks = dropdown.nextElementSibling;

            if (dropdownLinks.style.display === "block") {
                dropdownLinks.style.display = "none";
            } else {
                dropdownLinks.style.display = "block";
            }
        });
    }

}

document.addEventListener('DOMContentLoaded', function () {
    handleDropDown();

    handleSidebarItemDropdown();

    createActiveGroupEventListener();

    setCurrentActiveGroupFromWindow();

});
