$(document).ready(function () {
    'use strict';
    var base_url = $('meta[name="base_url"]').attr('content');

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Recovering... ').prop('disabled', true);
        $("input[name='email']").prop('disabled', true);

        var email = $("input[name='email']").val();

        $.ajax({
            url: base_url + "/api/user/reset_password",
            type: 'POST',
            dataType: "json",
            data: {
                email: email,
            },
            cache: false,

        }).done(function (data) {
            $('#submit').html('Reset').prop('disabled', false);
            $("input[name='email']").prop('disabled', false).val('');
            if (data.message) {
                displayErrors(data.message, 'alert alert-success');
                document.location.href = base_url;
            }

        }).fail(function (data) {
            var errors = JSON.parse(data.responseText).errors;
            displayErrors(errors, 'alert alert-danger');
            $('#submit').html('Reset').prop('disabled', false);
            $("input[name='email']").prop('disabled', false).val('');
        });


    });

});
