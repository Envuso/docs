const scrollToTopButton = document.getElementById('scroll-to-top');
const contentWrapper    = document.getElementById('content-wrapper');

contentWrapper.onscroll = function () {
    onDocumentScroll();
};

function onDocumentScroll()
{
    if (contentWrapper.scrollTop > 100) {
        scrollToTopButton.classList.add('opacity-100');
        scrollToTopButton.classList.remove('opacity-0');
    } else {
        scrollToTopButton.classList.add('opacity-0');
        scrollToTopButton.classList.remove('opacity-100');
    }
}

scrollToTopButton.addEventListener('click', () => {
    scrollToTop();
});

function scrollToTop()
{
    document.body.scrollTop            = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    document.getElementById('content-wrapper').scroll({top : 0, behavior : 'auto'});
}
