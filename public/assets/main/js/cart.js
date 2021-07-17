$(document).ready(function () {
    'use strict';
    var base_url = $('meta[name="base_url"]').attr('content');
    var api_token = $('meta[name="api_token"]').attr('content');

    if (api_token != undefined) {
        getCart();
    }


    $('.add_to_cart').click(function (e) {
        e.preventDefault();
        if (api_token == undefined | api_token == '') {
            var fail_errors = {
                'errors': [
                    'Please Login to add Product to Cart'
                ]
            };
            displayErrors(fail_errors, 'alert alert-danger');
            document.location.href = base_url + '/sign_in';
        } else {
            var prod = $('.add_to_cart').val();

                $.ajax({
                    url: base_url + "/api/user/add_cart",
                    type: 'POST',
                    dataType: "json",
                    cache: false,
                    data: {
                        product_id: prod,
                    },
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

                }).fail(function () {
                    var fail_errors = {
                        'errors': [
                            'An UnExpected Error Occured. Please Reload Page and try again.'
                        ]
                    };
                    displayErrors(fail_errors, 'alert alert-warning');
                });;
            }

    });


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
            var carts = data.carts;
            console.log(data);
            $('.cart_quantity').text(carts.length);
                if(carts.length > 0){
                    $('.cart-area').css('display','inline');
                    $('.cart-list').empty();
                    $('#total').empty();

                    var total = 0;
                    var total_currency;
                    jQuery.each(carts, function(i, val) {
                        var li = $('<li></li>');
                        var div = $('<div></div>').addClass('cart-item-desc');
                        var image_a = $('<a></a>').addClass('image').attr('href','#').append($('<img>').addClass('cart-thumb').attr('src',val.thumbnail.location));
                        var details = $('<div></div>').append($('<a></a>').attr('href','#').text(val.product),$('<p></p>').text(val.quantity +' x '+val.currency+val.price));
                        var span = $('<span></span>').addClass('dropdown-product-remove').append($('<i></i>').addClass('icofont-bin').attr('id',val.id));
                        total = total + Number(val.price);

                        $(div).append(image_a,details);
                        $(li).append(div,span).appendTo('.cart-list');
                        total_currency = val.currency;
                    });
                    $('#total').text((total_currency+total.toLocaleString()));
                }else{
                    $('.cart-area').css('display','none');
                }

        });
    }


    $('.cart-list').on('click','.icofont-bin', function(e){
        e.preventDefault();
        var cart_id = this.id;
        $.ajax({
            url: base_url + "/api/user/remove_from_cart/"+cart_id,
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

});

