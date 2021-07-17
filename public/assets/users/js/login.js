$(document).ready(function () {
    'use strict';
    var base_url = $('meta[name="base_url"]').attr('content');

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Authenticating ').prop('disabled', true);
        $("input[name='username']").prop('disabled', true);
        $("input[name='password']").prop('disabled', true);

        var token = $("input[name='_token']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        $.ajax({
            url: base_url + "/api/user/login",
            type: 'POST',
            dataType: "json",
            data: {
                username: username,
                password: password,
                _token: token
            },
            cache: false,

        }).done(function (data) {
            $('#submit').html('Login').prop('disabled', false);
            $("input[name='username']").prop('disabled', false);
            $("input[name='password']").prop('disabled', false);
            if (data.message) {
                displayErrors(data.message, 'alert alert-success');
                document.location.href = base_url + '/user/dashboard';
            }

        }).fail(function (data) {

            $("input[name='username']").prop('disabled', false);
            $("input[name='password']").prop('disabled', false);
            var errors = JSON.parse(data.responseText).errors;
            displayErrors(errors, 'alert alert-danger');
            $('#submit').html('Login').prop('disabled', false);


        });


    });

});
