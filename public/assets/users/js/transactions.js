$(document).ready(function () {
    'use strict';
    var api_route = base_url + "/api/user/transactions";
    getTransactions(api_route);

    function getTransactions(api_route) {
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            cache: false,
            headers: {
                api_token: api_token
            }

        }).done(function (data) {
            $('#transactions').empty();
            var records = data;
            if (records.length > 0) {
                var tr = $('<tr></tr>');
                var td = $('<td></td>');
                jQuery.each(records, function (i, val) {
                    var tr = $('<tr></tr>');
                    var td = $('<td></td>');
                    var tc = $('<td></td>');
                    $(tr).append(
                        $(td).clone().text(i + 1),
                        $(td).clone().text(val.transaction_date),
                        $(td).clone().text(val.branch),
                        $(td).clone().text(val.transaction_id),
                        $(td).clone().append(getStatus(val.status)),
                    );
                    jQuery.each(val.purchases, function (i, purchase) {
                        var price = purchase.price;
                        $(tc).append(
                            $('<span></span>').text(purchase.product + " ( " + val.currency + price.toLocaleString() + " * " + purchase.quantity + ") = " + val.currency + (purchase.price * purchase.quantity).toLocaleString()).append($('<br>'))
                        );
                    });
                    $(tr).append(tc,
                        $(td).clone().text(val.currency+val.sub_total),
                        $(td).clone().text(val.currency+val.service_charge),
                        $(td).clone().text(val.currency+val.total),
                        $(td).clone().append(getActionButton(val.status,val.transaction_id,val.payment))
                    );
                    $("#transactions").append(tr);

                });
                $('#transactions').append(tr);
            } else {
                var tr = $('<tr></tr>').append(
                    $('<td></td>').text('No Transactions has been made yet').attr('colspan',9)
                );
                $("#transactions").append(tr);


            }




        });
    }

    function getStatus(status) {
        if (status == '1') {
            return $('<span></span>').addClass('badge badge-success').text('Completed');
        } else {
            return $('<span></span>').addClass('badge badge-info').text('Pending');
        }
    }

    function getActionButton(status,transaction_id,$payment){
        if (status == '0' & $payment == '3')  {
            return $('<a></a>').addClass('btn btn-sm btn-info').text('Pay').attr('href',base_url+'/payment/'+transaction_id);
        }
    }



});
