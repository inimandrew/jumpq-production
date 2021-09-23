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
        $("input[name='email']").prop("disabled", true);

        var email = $("input[name='email']").val();

        $.ajax({
            url: base_url + "/api/user/reset_password",
            type: "POST",
            dataType: "json",
            data: {
                email: email,
            },
            cache: false,
        })
            .done(function (data) {
                if (data.message) {
                    displayErrors(
                        data.message,
                        "text-center py-2 bg-green-400 text-white font-semibold rounded-sm"
                    );
                    document.location.href = `${base_url}/auth/login`;
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
                $("#submit").html("Reset").prop("disabled", false);
                $("input[name='email']").prop("disabled", false).val("");
            });
    });
});
