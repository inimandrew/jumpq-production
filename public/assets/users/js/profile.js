$(document).ready(function () {
    "use strict";

    $("#update").click(function (e) {
        e.preventDefault();
        $("#update")
            .html(
                '<img class="mx-auto" src=' +
                    base_url +
                    "/assets/general_assets/ajax-loader.gif />"
            )
            .prop("disabled", true);
        $("#update-profile :input").prop("disabled", true);

        var photo = $("#photo");
        var photo_val;
        var formData = new FormData();
        if (photo[0].files[0] == undefined) {
            photo_val = photo.val();
        } else {
            photo_val = photo[0].files[0];
        }
        formData.append("photo", photo_val);
        formData.append("firstname", $("input[name='firstname']").val());
        formData.append("lastname", $("input[name='lastname']").val());
        formData.append("username", $("input[name='username']").val());
        formData.append("password", $("input[name='password']").val());
        formData.append(
            "password_confirmation",
            $("input[name='password_confirmation']").val()
        );
        formData.append("birthday", $("input[name='birthday']").val());
        formData.append("phone", $("input[name='phone']").val());

        $.ajax({
            url: base_url + "/api/user/update_profile",
            type: "POST",
            dataType: "json",
            headers: {
                api_token: api_token,
            },
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
        })
            .done(function (data) {
                if (data.message) {
                    displayErrors(
                        data.message,
                        "text-center py-2 bg-green-400 text-white font-semibold rounded-sm"
                    );
                    window.location.reload();
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
                $("input[name=password").val("");
                $("#update").html("Update Profile").prop("disabled", false);
                $("#update-profile :input").prop("disabled", false);
                $("input[type='email']").prop("disabled", true);
            });
    });
});
