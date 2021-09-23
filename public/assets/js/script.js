$(document).ready(function () {
    "use strict";

    $("#button-mobile").click(function (e) {
        $("#mobile-nav").toggleClass("hidden");
        $("#open-icon").toggleClass("hidden");
        $("#close-icon").toggleClass("hidden");
    });

    $(window).scroll(function () {
        if ($(window).width() >= 1024) {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > 0) {
                $("#nav")
                    .removeClass("lg:bg-transparent")
                    .addClass("bg-white fixed top-0 left-0 right-0");
            } else {
                $("#nav")
                    .removeClass("bg-white fixed top-0 left-0 right-0")
                    .addClass("lg:bg-transparent");
            }
        }
    });

    $(document).ready(function () {
        $(".mainLink").each(function () {
            if (this.href == window.location.href) {
                $(this).addClass("activeLink");
            }
        });
    });

    $(document).ready(function () {
        $(".authLink").each(function () {
            if (this.href == window.location.href) {
                $(this).addClass("activeAuthLink");
            }
        });
    });
});
