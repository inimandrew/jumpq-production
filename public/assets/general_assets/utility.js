var base_url = $('meta[name="base_url"]').attr("content");

var api_token = $('meta[name="api_token"]').attr("content");
function displayErrors(data, css_class, useScroll = true) {
    $("#message").empty();
    if (useScroll) {
        scrollToTop();
    }

    jQuery.each(data, function (i, val) {
        var error_block = document.createElement("div");
        $(error_block)
            .addClass(css_class)
            .html("<span>" + val + "</span>")
            .appendTo("#message");
    });

    $("#message")
        .fadeIn(500)
        .delay(6000)
        .fadeOut(2000, function () {
            $("#message").css("display", "none");
        });
}

function scrollToTop() {
    $(window).scrollTop(0);
}

function unExpectedError() {
    var fail_errors = {
        errors: [
            "An UnExpected Error Occured. Please Reload Page and try again.",
        ],
    };
    displayErrors(fail_errors, "alert alert-warning");
}
