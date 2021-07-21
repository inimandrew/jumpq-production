$(document).ready(function () {
    'use strict';
    var product_id = $('meta[name="product"]').attr('content');
    var api_route = base_url + '/api/product/' + product_id;

    getProduct(api_route);


    function getProduct(api_route){
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            cache: false,

        }).done(function (data) {
            var product = data;
            $('#overview').text(product.description);
            $('.title').text(product.name);
            $('.price').text(product.currency + product.price);
            $('.add_to_cart').val(product_id);
            if(product.quantity == 0){
                $('#qty2').attr('max',product.quantity);
                $('#qty2').attr('min',product.quantity);
                $('#qty2').attr('value',product.quantity);
            }else{
                $('#qty2').attr('max',product.quantity);
                $('#qty2').attr('min',1);

            }


            jQuery.each(product.big_images, function (i, val) {
                if(i == 0){
                    var div = $('<div></div>').addClass('carousel-item active');
                }else{
                    var div = $('<div></div>').addClass('carousel-item');
                }

                var a = $('<a></a>').addClass('gallery_img').attr('href',val.location).attr('title','image '+i).append($('<img>').addClass('d-block w-100').attr('src', val.location).attr('alt','image '+i));
                var li = $('<li></li>').attr('data-target','#product_details_slider').attr('data-slide-to',i).css('background-image','url('+val.location+')');
                $(div).append(a).appendTo('.carousel-inner');
                $('.carousel-indicators').append(li);
            });

        }).fail(function () {
            unExpectedError();
        });
    }


});
