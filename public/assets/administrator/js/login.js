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
            url: base_url + "/api/admin/login",
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
                if (data.errors) {
                    displayErrors(
                        data.errors,
                        "text-center py-2 bg-red-400 text-white font-semibold rounded-sm"
                    );
                } else if (data.message) {
                    displayErrors(
                        data.message,
                        "text-center py-2 bg-green-400 text-white font-semibold rounded-sm"
                    );

                    document.location.href = base_url + "/admin/dashboard";
                }
            })
            .fail(function () {
                var fail_errors = {
                    errors: [
                        "An UnExpected Error Occured. Please Reload Page and try again.",
                    ],
                };

                displayErrors(
                    fail_errors,
                    "text-center py-2 bg-red-400 text-white font-semibold rounded-sm"
                );
            })
            .complete(() => {
                $("#submit").html("Login").prop("disabled", false);
                $("input[name='username']").prop("disabled", false);
                $("input[name='password']").prop("disabled", false);
            });
    });
});
