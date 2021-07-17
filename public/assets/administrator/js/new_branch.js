$(document).ready(function () {
    'use strict';

    function getCurrencies() {
        $.ajax({
            url: base_url + "/api/currencies",
            type: 'GET',
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('api_token', api_token);
            },
            cache: false,

        }).done(function (data) {

            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');
            } else {
                jQuery.each(data, function (i, val) {
                    var option = $('<option></option>').text(val.name + ' - ' + val.symbol).attr('value', val.id);
                    $('#currency').append(option);
                });
            }

        });
    }

    getCurrencies();

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Submitting ').prop('disabled', true);
        $("#create-store :input").prop('disabled', true);

        var token = $("input[name='_token']").val();
        var parent = $("select[name='parent']").val();
        var store_type = $("select[name='store_type']").val();
        var branch_name = $("input[name='branch_name']").val();
        var branch_address = $("input[name='branch_address']").val();
        var branch_phone = $("input[name='branch_phone']").val();
        var admin_firstname = $("input[name='admin_firstname']").val();
        var admin_lastname = $("input[name='admin_lastname']").val();
        var admin_username = $("input[name='admin_username']").val();
        var admin_email = $("input[name='admin_email']").val();
        var admin_phone = $("input[name='admin_phone']").val();
        var currency = $("select[name='currency']").val();
        var password = $("input[name='password']").val();
        var password_confirmation = $("input[name='password_confirmation']").val();
        var country = $("input[name='country']").val();
        var state = $("input[name='state']").val();

        $.ajax({
            url: base_url + "/api/store/new_branch",
            type: 'POST',
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('api_token', api_token);
            },
            data: {
                parent: parent,
                store_type: store_type,
                branch_name: branch_name,
                branch_address: branch_address,
                branch_phone: branch_phone,
                admin_firstname: admin_firstname,
                admin_lastname: admin_lastname,
                admin_email: admin_email,
                admin_phone: admin_phone,
                admin_username: admin_username,
                password: password,
                currency: currency,
                password_confirmation: password_confirmation,
                country: country,
                state: state,
                _token: token
            },
            cache: false,

        }).done(function (data) {
            scrollToTop();
            $('#submit').html('Submit').prop('disabled', false);
            $("#create-store :input").prop('disabled', false);


            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.message) {
                $('#create-branch').trigger('reset');
                displayErrors(data.message, 'alert alert-success');
            }

        }).fail(function () {
            $('#submit').html('Submit').prop('disabled', false);
            $("#create-store :input").prop('disabled', false);
            var fail_errors = {
                'errors': [
                    'An UnExpected Error Occured. Please Reload Page and try again.'
                ]
            };
            displayErrors(fail_errors, 'alert alert-warning');
            $('#message').fadeIn(1000).delay(4000).fadeOut(1000, function () {
                $("#message").css('display', 'none');

            });

        });


    });

});
