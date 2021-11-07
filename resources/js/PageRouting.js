import Prism              from 'prismjs';
import { setActiveGroup } from './PageActiveGroup';
import { scrollToTop }    from './ScrollToTop';


document.addEventListener('DOMContentLoaded', function () {
    if (!window.currentPage?.pageUrl) {
        window.currentPage.pageUrl = window.location.origin + window.location.pathname;
    }

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

function setPageData(pageData, pushState = false)
{
    console.log('pageData', pageData);
    document.getElementById('page_content').innerHTML = pageData.view;
    document.getElementById('canonical').setAttribute('href', pageData.url);

    document.title = `Envuso - ${pageData.title}`;

    setActiveGroup(pageData.activeGroup.route);
    Prism.highlightAll();

    if (pushState) {
        window.history.pushState(pageData, pageData.title, pageData.pageUrl);
        scrollToTop();
    }
}

function getPage(pageUrl, pushState = false)
{
    if (window.currentPage?.url === pageUrl) {
        console.log('Page is same... returning.');
        return;
    }

    axios(pageUrl).then(({data}) => {
        const pageData = {...data, pageUrl};

        setActiveMenuItems(data);

        if (!pageData.path.startsWith('/')) {
            pageData.path = '/' + pageData.path;
        }

        pageData.currentFullUrl = window.location.href;

        if (window.currentPage) {
            window.currentPage = pageData;
        }

        setPageData(pageData, pushState);
    });
}

window.onpopstate = (event) => {
    const pageData = event.state;

    //    if (window.location.hash) {
    //        const activeBrowserUrl = window.location.origin + window.location.pathname;
    //        const {title, pageUrl} = window.currentPage;
    //
    //        if (pageUrl === activeBrowserUrl) {
    //            window.history.pushState(window.currentPage, title, pageUrl);
    //            console.log('pushed state');
    //        } else {
    //            console.log('Dont know what to do here....');
    //        }
    //    }

    //if (event.state) {
    //    setPageData(event.state, false);
    //}
    getPage(document.location.href, false);
};

export function setActiveMenuItems(data)
{
    for (let element of document.getElementsByClassName('menu-item')) {
        if (!element?.dataset?.loadPage) {
            continue;
        }

        element.classList.remove('menu-item-active');

        if (element.dataset.loadPage === data.url) {
            element.classList.toggle('menu-item-active');
        }

    }
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
