import Prism              from 'prismjs';
import { setActiveGroup } from './PageActiveGroup';


document.addEventListener('DOMContentLoaded', function () {
    for (let element of document.getElementsByClassName('menu-item')) {

        if (!element?.dataset?.loadPage) {
            continue;
        }

        element.addEventListener('click', (event) => {
            event.preventDefault();

            const pageUrl = element.dataset.loadPage;

            clearActiveMenuItems();
            element.classList.toggle('menu-item-active');

            getPage(pageUrl, true);
        });

    }
});

window.onpopstate = (event) => {
    getPage(document.location.href, false);
};

function getPage(pageUrl, pushState = false)
{
    axios(pageUrl).then(({data}) => {
        document.getElementById('page_content').innerHTML = data.view;
        document.getElementById('canonical').setAttribute('href', data.url);
        scrollToTop();
        document.title = `Envuso - ${data.title}`;

        setActiveGroup(data.activeGroup.route);
        Prism.highlightAll();
        if (pushState) {
            window.history.pushState(null, data.title, pageUrl);
        }
    });
}

export function clearActiveMenuItems()
{
    for (let element of document.getElementsByClassName('menu-item')) {
        if (!element?.dataset?.loadPage) {
            continue;
        }

        element.classList.remove('menu-item-active');
    }
}
