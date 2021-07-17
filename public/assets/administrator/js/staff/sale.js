$(document).ready(function () {
    'use strict';
    var api_route = base_url + "/api/staff/transaction";
    var api_route2 = base_url + "/api/staff/clear_payment";
    var carts = [];
    var barcodes = {};

    function getSaleRecord(api_route, transaction_id) {
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Retreiving... ').prop('disabled', true);
        $("input[name='unique_id']").val('')
        $.ajax({
            url: api_route + '/' + transaction_id,
            type: 'GET',
            dataType: "json",
            cache: false,
            headers: {
                api_token: api_token
            }

        }).done(function (data) {
            $('#submit').text('Submit').prop('disabled', false);
            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');
            } else {
                $('#transaction').empty();
                $('#bcode').removeClass('hide');
                var record = data;

                var tr = $('<tr></tr>').append(
                    $('<td></td>').text(record.transaction_date),
                    $('<td></td>').text(record.transaction_id),
                    $('<td></td>').append(getStatus(record.status)),
                    $('<td></td>').text(record.staff),
                    $('<td></td>').text(record.buyer_name),
                    $('<td></td>').text(record.buyer_phone)
                );
                var td = $('<td></td>');
                var sum = 0;
                carts = record.purchases;
                jQuery.each(record.purchases, function (i, purchase) {
                    barcodes[purchase['barcode']] = {
                        total: purchase.quantity,
                        count: 0,
                    };
                    var price = purchase.price;
                    $(td).append(
                        $('<span></span>').text(purchase.product + " ( " + record.currency + price.toLocaleString() + " * " + purchase.quantity + ") = " + record.currency + (purchase.price * purchase.quantity).toLocaleString()).append($('<br>'))
                    );
                    sum = sum + (purchase.price * purchase.quantity);
                });
                $(tr).append(td,
                    $('<td></td>').text(record.currency + record.sub_total),
                    $('<td></td>').text(record.currency + record.service_charge),
                    $('<td></td>').text(record.currency + (record.total)),
                    $('<td></td>').html(getButton(record)),
                );

                $('#transaction').append(tr);
            }

        }).fail(function () {
            $('#submit').text('Submit').prop('disabled', false);
            unExpectedError();
        });
    }

    $("input[name='barcode']").keypress(function (event) {

        if (event.which == '10' || event.which == '13') {
            event.preventDefault();
            event.stopImmediatePropagation();
            var bcode = $("input[name='barcode']").val();
            $("input[name='barcode']").val('');
            var message = validateBarcode(bcode);
            if (message == false) {
                var fail_errors = {
                    'errors': [
                        'Product with Barcode ' + bcode + ' was not added for purchase'
                    ]
                };
                displayErrors(fail_errors, 'alert alert-danger');
                displayErrors(fail_errors, 'alert alert-danger');
                    $('#led').addClass('theft-blink');
                    setInterval(function () {
                        $('#led').removeClass('theft-blink');
                    }, 1000);
            } else {
                barcodes[bcode].count = barcodes[bcode].count + 1;
                if (barcodes[bcode].count > barcodes[bcode].total) {
                    var fail_errors = {
                        'errors': [
                            'Product with Barcode ' + bcode + ' has more quantity than what was paid for'
                        ]
                    };
                    displayErrors(fail_errors, 'alert alert-danger');
                    $('#led').addClass('blink-bg');
                    setInterval(function () {
                        $('#led').removeClass('blink-bg');
                    }, 1000);
                } else {
                    $('#led').addClass('good-blink');
                    setInterval(function () {
                        $('#led').removeClass('good-blink');
                    }, 1000);
                }
            }
        }
    });

    function validateBarcode(barcode) {
        var response = false;
        jQuery.each(carts, function (i, val) {
            if (val['barcode'] == barcode) {
                response = true;
            }
        });

        return response;
    }

    function clearTransaction(api_route2, transaction_id) {
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Retreiving... ').prop('disabled', true);
        $("input[name='unique_id']").val()
        $.ajax({
            url: api_route2,
            type: 'POST',
            dataType: "json",
            cache: false,
            headers: {
                api_token: api_token
            },
            data: {
                transaction_id: transaction_id
            }

        }).done(function (data) {
            $('#submit').text('Submit').prop('disabled', false);
            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');
            } else {
                $('#transaction').empty();
                displayErrors(data.message, 'alert alert-success');

            }

        }).fail(function () {
            $('#submit').text('Submit').prop('disabled', false);
            unExpectedError();
        });
    }



    function getStatus(status) {
        if (status == '1') {
            return $('<span></span>').addClass('label label-success').text('Completed');
        } else {
            return $('<span></span>').addClass('label label-info').text('Pending');
        }
    }

    function getButton(record) {
        if (record.status == '0') {
            return $('<button></button>').addClass('btn btn-primary clear_payment').text('Clear Payment').attr('type', 'button').val(record.transaction_id);
        } else {
            return $('<a></a>').addClass('btn btn-sm btn-info').text('Reciept').attr('href', record.receipt_url)
        }
    }

    $('#submit').click(function (e) {
        e.preventDefault();
        var unique_id = $("input[name='unique_id']").val();

        if (!unique_id) {
            var fail_errors = {
                'errors': [
                    'Transaction-id is required.'
                ]
            };
            displayErrors(fail_errors, 'alert alert-danger');
        } else {
            getSaleRecord(api_route, unique_id);
        }

    });

    $('#transaction').on('click', '.clear_payment', function (e) {
        e.preventDefault();
        var unique_id = this.value;

        if (!unique_id) {
            var fail_errors = {
                'errors': [
                    'Transaction-id is required.'
                ]
            };
            displayErrors(fail_errors, 'alert alert-danger');
        } else {
            clearTransaction(api_route2, unique_id);
        }

    });



});
