$(document).ready(function () {
    'use strict';

    var api_route = base_url + "/api/staff/add_subaccount";

    $('#payment').change(function () {
        $('#submit').html('Submit').prop('disabled', true);
        const payment = $('#payment').val();
        if (payment) {
            $.ajax({
                url: base_url + "/api/staff/banks/" + payment,
                type: 'GET',
                dataType: "json",
                headers: {
                    api_token: api_token
                },
                cache: false,

            }).done(function (data) {
                $('#submit').html('Submit').prop('disabled', false);
                const banks = data.banks
                $('#banks').empty()
                $('<option></option>').val('').text('Select a Bank')
                banks.forEach((bank) => {
                    $('<option></option>').val(bank.id).text(bank.name).appendTo('#banks')
                })
            });
        }

    })

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Submitting').prop('disabled', true);
        $("#sub_accounts :input").prop('disabled', true);

        var currency_id = $('select[name="currency_id"]').val();
        var bank_id = $('select[name="bank_id"]').val();
        var account_number = $('input[name="account_number"]').val();

        $.ajax({
            url: api_route,
            type: 'POST',
            dataType: "json",
            headers: {
                api_token: api_token
            },
            data: {
                currency_id: currency_id,
                bank_id: bank_id,
                account_number: account_number,
            },
            cache: false,

        }).done(function (data) {
            $('#submit').html('Submit').prop('disabled', false);
            $("#sub_accounts :input").prop('disabled', false);
            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.message) {
                displayErrors(data.message, 'alert alert-success');
                document.location.href = base_url + '/staff/account';
            }

        }).fail(function () {
            $('#submit').html('Submit').prop('disabled', false);
            $("#sub_accounts :input").prop('disabled', false);
            unExpectedError();
        });
    });


});
