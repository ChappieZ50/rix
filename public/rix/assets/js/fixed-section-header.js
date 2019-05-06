// Fixed Section Header
window.onscroll = function () {
    sectionHeader();
};
var header = document.getElementById("section-header");
var content = document.getElementById('section-content');
var sticky = header.offsetTop;

function sectionHeader() {
    if (window.pageYOffset > sticky + 73) {
        if ($('.delete_selected .badge').text() > 0)
            showSticky();
        else
            hideSticky();
    } else {
        hideSticky();
    }
}

function showSticky() {
    if (window.pageYOffset > sticky + 73) {
        header.classList.add("section-fixed-sticky");
        content.classList.add("section-content-sticky");
    }
}

function hideSticky() {
    header.classList.remove("section-fixed-sticky");
    content.classList.remove("section-content-sticky");
}
