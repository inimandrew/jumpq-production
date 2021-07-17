$(document).ready(function () {
    'use strict';

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Submitting ').prop('disabled', true);
        $("#register-user :input").prop('disabled', true);

        var token = $("input[name='_token']").val();
        var firstname = $("input[name='firstname']").val();
        var lastname = $("input[name='lastname']").val();
        var username = $("input[name='username']").val();
        var email = $("input[name='email']").val();
        var phone = $("input[name='phone']").val();
        var password = $("input[name='password']").val();
        var password_confirmation = $("input[name='password_confirmation']").val();

        $.ajax({
            url: base_url + "/api/user/register",
            type: 'POST',
            dataType: "json",

            data: {
                firstname: firstname,
                lastname: lastname,
                email: email,
                phone: phone,
                username: username,
                password: password,
                password_confirmation: password_confirmation,
                _token: token
            },
            cache: false,

        }).done(function (data) {
            $('#submit').html('Submit').prop('disabled', false);
            $("#register-user :input").prop('disabled', false);

             if (data.message) {
                $('#register-user').trigger('reset');
                displayErrors(data.message, 'alert alert-success');
            }

        }).fail(function (data) {
            $("#register-user :input").prop('disabled', false);
            $('#submit').html('Submit').prop('disabled', false);
            var errors = JSON.parse(data.responseText).errors;
            displayErrors(errors, 'alert alert-danger');

        });


    });

});
