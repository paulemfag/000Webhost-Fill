$(function () {
    window.addEventListener("scroll", bringmenu);
    function bringmenu() {
        if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
            document.getElementById("navbarSupportedContent").style.bottom = "-100%";
        } else {
            document.getElementById("navbarSupportedContent").style.bottom = "0";
        }
    }
});
