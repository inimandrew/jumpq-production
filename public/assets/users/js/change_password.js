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
        $("input[name='password']").prop("disabled", true);
        $("input[name='password_confirmation']").prop("disabled", true);

        var user_id = $("input[name='user_id']").val();
        var password = $("input[name='password']").val();
        var password_confirmation = $(
            "input[name='password_confirmation']"
        ).val();

        $.ajax({
            url: base_url + "/api/user/change_password",
            type: "POST",
            dataType: "json",
            data: {
                user_id: user_id,
                password: password,
                password_confirmation: password_confirmation,
            },
            cache: false,
        })
            .done(function (data) {
                if (data.message) {
                    displayErrors(
                        data.message,
                        "text-center py-2 bg-green-400 text-white font-semibold rounded-sm",
                        10000
                    );

                    document.location.href = base_url + "/auth/login";
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
                $("#submit").text("Submit").prop("disabled", false);
                $("input[name='password']").prop("disabled", false);
                $("input[name='password_confirmation']").prop(
                    "disabled",
                    false
                );
            });
    });
});
