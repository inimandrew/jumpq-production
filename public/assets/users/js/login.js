$(document).ready(function () {
    "use strict";
    var base_url = $('meta[name="base_url"]').attr("content");

    $("#submit").click(function (e) {
        e.preventDefault();
        $("#submit")
            .html(
                `<img class='mx-auto' src='${base_url}/assets/general_assets/ajax-loader.gif'/>`
            )
            .prop("disabled", true);
        $("input[name='username']").prop("disabled", true);
        $("input[name='password']").prop("disabled", true);

        var token = $("input[name='_token']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        $.ajax({
            url: base_url + "/api/user/login",
            type: "POST",
            dataType: "json",
            data: {
                username: username,
                password: password,
                _token: token,
            },
            cache: false,
        })
            .done(function (data) {
                if (data.message) {
                    displayErrors(
                        data.message,
                        "text-center py-2 bg-green-400 text-white font-semibold rounded-sm"
                    );
                    document.location.href = base_url + "/user/home";
                }
            })
            .fail(function (data) {
                var errors = JSON.parse(data.responseText).errors;
                displayErrors(
                    errors,
                    "text-center py-2 bg-red-400 text-white font-semibold rounded-sm"
                );
            })
            .complete(() => {
                $("input[name='username']").prop("disabled", false);
                $("input[name='password']").prop("disabled", false);
                $("#submit").html("Login").prop("disabled", false);
            });
    });
});
