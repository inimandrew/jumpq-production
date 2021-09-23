$(document).ready(function () {
    "use strict";

    console.log(base_url);
    $("#submit").click(function (e) {
        e.preventDefault();
        $("#submit")
            .html(
                `<img class='mx-auto' src='${base_url}/assets/general_assets/ajax-loader.gif'/>`
            )
            .prop("disabled", true);
        $("#login-staff :input").prop("disabled", true);

        var token = $("input[name='_token']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        $.ajax({
            url: base_url + "/api/staff/login",
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

                    document.location.href = base_url + "/staff/home";
                }
            })
            .fail(function (error) {
                var main_errors = error.responseJSON.errors;
                for (var index in main_errors) {
                    displayErrors(
                        main_errors[index],
                        "text-center py-2 bg-red-400 text-white font-semibold rounded-sm"
                    );
                }
            })
            .complete(() => {
                $("#login-staff :input").prop("disabled", false);
                $("#submit").html("Login").prop("disabled", false);
            });
    });
});
