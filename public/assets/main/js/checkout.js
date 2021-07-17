$(document).ready(function () {
    'use strict';
    var base_url = $('meta[name="base_url"]').attr('content');
    var api_token = $('meta[name="api_token"]').attr('content');
    var service_charge = $('input[name="service_charge"]').val();
    getCart();

    function getCart() {
        $.ajax({
            url: base_url + "/api/user/cart",
            type: 'GET',
            dataType: "json",
            cache: false,
            headers: {
                api_token: api_token
            }

        }).done(function (data) {
            var carts = data;
            $('#cart_details').empty();
            var sub_total = 0.00;
            var vat, final_total, currency;

            if (carts.length > 0) {

                jQuery.each(carts, function (i, val) {
                    var tr = $('<tr></tr>');
                    var td = $('<td></td>');
                    var product_total = Number(val.quantity * val.price);
                    sub_total += product_total;
                    $(tr).append(
                        $(td).attr('scope', 'row').html($('<button></button>').attr('id', val.id).html($('<i></i>').addClass('icofont-ui-delete')).attr('type', 'button').addClass('btn btn-xs btn-circle btn-secondary remove')).clone(),
                        $(td).html($('<img>').attr('src', val.thumbnail.location)).clone(),
                        $(td).text(val.product).clone(),
                        $(td).text(val.currency + Number(val.price).toFixed(2)).clone(),
                        $(td).text(val.quantity).clone(),
                        $(td).text(val.currency + Number(product_total).toFixed(2)).clone()
                    ).appendTo('#cart_details');
                    currency = val.currency;
                });
                vat = sub_total * (service_charge/100).toFixed(3);
                final_total = vat + sub_total;
                $('#sub_total').text(currency + Number(sub_total).toFixed(2));
                $('#vat').text(currency + Number(vat).toFixed(2));
                $('#total').text(currency + Number(final_total).toFixed(2));

            } else {
                $('#sub_total').text(0.00);
                $('#vat').text(0.00);
                $('#total').text(0.00);
                $('<tr></tr>').append(
                    $('<td></td>').attr('colspan', 6).text('No Product added to cart')
                ).appendTo('#cart_details');

            }

        });

        $('#cart_details').on('click', '.remove', function (e) {
            e.preventDefault();
            var cart_id = this.id;
            $.ajax({
                url: base_url + "/api/user/remove_from_cart/" + cart_id,
                type: 'GET',
                dataType: "json",
                cache: false,
                headers: {
                    api_token: api_token
                }

            }).done(function (data) {
                if (data.errors) {
                    displayErrors(data.errors, 'alert alert-danger');

                } else if (data.message) {
                    displayErrors(data.message, 'alert alert-success');
                }
                getCart();
            });
        });
    }



});
