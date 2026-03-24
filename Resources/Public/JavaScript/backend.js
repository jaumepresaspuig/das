window.addEventListener("load", function () {
    var nav_tabs = document.getElementsByClassName("t3js-tabs");
    if (nav_tabs.length) {
        var tabs = nav_tabs[0].getElementsByTagName("A");
        if (tabs.length) {
            for (var i = 0; i < tabs.length; i++) {
                var innerHTML = tabs[i].innerHTML;
                if (innerHTML.includes("Das:", 0)) {
                    tabs[i].classList.add("das");
                }
            } 
        }
    }
}, false);
