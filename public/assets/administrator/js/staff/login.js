$(document).ready(function () {
    'use strict';

    console.log(base_url);
    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Authenticating ').prop('disabled', true);
        $("#login-staff :input").prop('disabled', true);


        var token = $("input[name='_token']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        $.ajax({
            url: base_url + "/api/staff/login",
            type: 'POST',
            dataType: "json",
            data: {
                username: username,
                password: password,
                _token: token
            },
            cache: false,

        }).done(function (data) {
            $("#login-staff :input").prop('disabled', false);
            $('#submit').html('Login').prop('disabled', false);

            if (data.message) {
                displayErrors(data.message, 'alert alert-success');

                document.location.href = base_url + '/staff/home';
            }




        }).fail(function (error) {
            $("#login-staff :input").prop('disabled', false);

            var main_errors = error.responseJSON.errors
            for (var index in main_errors) {
                displayErrors(main_errors[index], 'alert alert-danger');
            }

            $('#submit').html('Login').prop('disabled', false);

        });


    });

});
