$(document).ready(function () {
    'use strict';
    var base_url = $('meta[name="base_url"]').attr('content');

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Recovering... ').prop('disabled', true);
        $("input[name='password']").prop('disabled', true);
        $("input[name='password_confirmation']").prop('disabled', true);

        var user_id = $("input[name='user_id']").val();
        var password = $("input[name='password']").val();
        var password_confirmation = $("input[name='password_confirmation']").val();

        $.ajax({
            url: base_url + "/api/user/change_password",
            type: 'POST',
            dataType: "json",
            data: {
                user_id: user_id,
                password: password,
                password_confirmation: password_confirmation,
            },
            cache: false,

        }).done(function (data) {

            if (data.message) {
                displayErrors(data.message, 'alert alert-success',10000);

                document.location.href = base_url + '/sign_in';
            }
            $('#submit').html('CHANGE PASSWORD').prop('disabled', false);
            $("input[name='password']").prop('disabled', false).val('');
            $("input[name='password_confirmation']").prop('disabled', false).val('');

        }).fail(function (data) {
            var errors = JSON.parse(data.responseText).errors;
            displayErrors(errors, 'alert alert-danger');
        });
        $('#submit').html('CHANGE PASSWORD').prop('disabled', false);
        $("input[name='password']").prop('disabled', false);
        $("input[name='password_confirmation']").prop('disabled', false);

    });

});
