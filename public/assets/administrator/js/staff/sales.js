$(document).ready(function () {
    'use strict';
    var api_route = base_url + "/api/staff/sales_records/null/null";

    getSalesRecord(api_route);

    function getSalesRecord(api_route, start_date = null, end_date = null) {
        if (start_date != null & end_date != null) {
            api_route = base_url + "/api/staff/sales_records/" + start_date + '/' + end_date
        }
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            cache: false,
            headers: {
                api_token: api_token
            }

        }).done(function (data) {
            $('#date_picker').text('Submit').prop('disabled', false);
            $('#products_data').empty();
            var records = data.data;
            if (records.length > 0) {
                jQuery.each(records, function (i, val) {
                    var tr = $('<tr></tr>').append(
                        $('<td></td>').text((i + 1)),
                        $('<td></td>').text(val.transaction_date),
                        $('<td></td>').text(val.transaction_id),
                        $('<td></td>').append(getStatus(val.status)),
                        $('<td></td>').text(val.staff),
                        $('<td></td>').text(val.buyer_name),
                        $('<td></td>').text(val.buyer_phone)
                    );
                    var td = $('<td></td>');
                    var sum = 0;
                    jQuery.each(val.purchases, function (i, purchase) {
                        var price = purchase.price;
                        $(td).append(
                            $('<span></span>').text(purchase.product + " ( " + val.currency + price.toLocaleString() + " * " + purchase.quantity + ") = " + val.currency + (purchase.price * purchase.quantity).toLocaleString()).append($('<br>'))
                        );
                        sum = sum + (purchase.price * purchase.quantity);
                    });
                    $(tr).append(td,
                        $('<td></td>').text(val.currency + val.sub_total),
                        $('<td></td>').text(val.currency + val.service_charge),
                        $('<td></td>').text(val.currency + (val.total)),
                        $('<td></td>').html($('<a></a>').addClass('btn btn-sm btn-info').text('Reciept').attr('href', val.receipt_url)),
                    );

                    $('#products_data').append(tr);
                });
                pagination(api_route, data);
            }

        }).fail(function () {
            unExpectedError();
        });
    }

    $('#date_picker').click(function (e) {
        e.preventDefault();
        var start = $('input[name="start"]').val();
        var end = $('input[name="end"]').val();

        if (start.length == 0 | end.length == 0) {
            var fail_errors = {
                'errors': [
                    'All Dates input are required'
                ]
            };
            displayErrors(fail_errors, 'alert alert-info');
        } else {
            $('#date_picker').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Retrieving Data... ').prop('disabled', true);
            getSalesRecord(api_route, start, end);

        }
    });

    function pagination(api_route, data) {
        window.lis = {
            'first': api_route,
            'prev': data.prev,
            'content': data.current_page + " / " + data.last_page,
            'next': data.next,
            'last': data.last_page_url,
        };

        var text = {
            'first': "<<",
            'prev': "<",
            'next': ">",
            'last': ">>"
        };
        $('.pagination').empty();
        jQuery.each(lis, function (i, val) {
            var li = document.createElement('li');
            var link = document.createElement('a');
            if (i == "content") {
                $(link).text(val);
                $(li).addClass('footable-page-arrow active').append(link).appendTo('.pagination');
            } else {
                if (val == null) {
                    $(link).text(text[i]).attr('id', '#');
                    $(li).addClass('footable-page-arrow disabled').append(link).appendTo('.pagination');
                } else {
                    $(link).attr('id', i).attr('href', '#' + i).text(text[i]);
                    $(li).addClass('footable-page-arrow').append(link).appendTo('.pagination');
                }

            }

        });
    }

    $(".pagination").on("click", "a", function (event) {
        var index = (this).id;
        if (index != '#') {
            var new_api_route = lis[index];
            getSalesRecord(new_api_route);
        }

    });

    function getStatus(status) {
        if (status == '1') {
            return $('<span></span>').addClass('label label-success').text('Completed');
        } else {
            return $('<span></span>').addClass('label label-info').text('Pending');
        }
    }



});
