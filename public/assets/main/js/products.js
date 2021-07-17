$(document).ready(function () {
    'use strict';
    var branch = $('meta[name="branch"]').attr('content');
    var api_route = base_url + '/api/products/' + branch;

    getCategories(branch);
    getProduct(api_route);

    function getCategories(branch_id) {
        $.ajax({
            url: base_url + "/api/categories/" + branch_id,
            type: 'GET',
            dataType: "json",
            cache: false,

        }).done(function (data) {
            var categories = data;

            jQuery.each(categories, function (i, val) {
                var div = $('<div></div>').addClass('custom-control custom-checkbox d-flex align-items-center mb-2');
                var label = $('<label></label>').addClass('custom-control-label').text(val.name).attr('for', 'customCheck' + val.id);
                var span = $('<span></span>').addClass('text-muted').text(' (' + val.product_count + ')');
                var input = $('<input>').attr('type', 'checkbox').addClass('custom-control-input').attr('id', 'customCheck' + val.id).val(val.id);
                $(span).appendTo(label);
                $(div).append(input).append(label);
                $(div).appendTo('.widget-desc');
            });

        }).fail(function () {
            unExpectedError();
        });
    }


    function getProduct(api_route) {
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            cache: false,

        }).done(function (data) {
            $('#product_content').empty();
            var k = 0;
            jQuery.each(data.data, function (i, val) {

                var product_div = $('<div></div>').addClass('single-product-area mb-30');

                var product_description = $('<div></div>').addClass('product_description').append($('<p></p>').addClass('brand_name').text(val.category_name))
                    .append($('<a></a>').attr('href', base_url + '/product/' + val.id).text(val.name)).append($('<h6></h6>').addClass('product-price').text(val.currency + val.price));

                var cart = $('<div></div>').addClass('product_add_to_cart').append($('<a></a>').attr('href', base_url + '/product/' + val.id)
                    .html($('<i></i>').addClass('icofont-shopping-cart').text('See More Details')));


                var product_image = $('<div></div>').addClass('product_image');
                $(product_image).append($('<img>').addClass('normal_img').attr('src', val.medium[0].location)).append($('<img>').addClass('hover_img').attr('src', val.medium[0].location));
                $(product_image).appendTo(product_div);
                $(cart).appendTo(product_description);
                $(product_description).appendTo(product_div);
                $('<div></div>').addClass('col-9 col-sm-12 col-md-6 col-lg-4').append(product_div).appendTo('#product_content');

            });
            pagination(data.next, data.prev, data.last_page, data.current_page);

        }).fail(function () {
            unExpectedError();
        });
    }


    function pagination(next_url, prev_url, last_page, current_page) {
        $('#pagination').empty();

        var prev = $('<li></li>').addClass('page-item');
        if (prev_url == null) {
            var prev_a = $('<a></a>').addClass('page-link').attr('id', '#');
        } else {
            var prev_a = $('<a></a>').addClass('page-link').attr('id', prev_url);
        }

        var prev_a_i = $('<i></i>').addClass('fa fa-angle-left').attr('aria-hidden', "true");

        $(prev_a).append(prev_a_i).appendTo(prev);


        $('#pagination').append(prev);

        for (let index = 1; index <= last_page; index++) {
            var main;
            if (current_page == index) {
                main = $('<li></li>').addClass('page-item active');
            } else {
                main = $('<li></li>').addClass('page-item');
            }

            var main_a = $('<a></a>').addClass('page-link').text(index).attr('id', api_route + '?page=' + index);
            $(main).append(main_a).appendTo('#pagination');
        }

        var next = $('<li></li>').addClass('page-item');
        if (next_url == null) {
            var next_a = $('<a></a>').addClass('page-link').attr('id', '#');
        } else {
            var next_a = $('<a></a>').addClass('page-link').attr('id', next_url);
        }

        var next_a_i = $('<i></i>').addClass('fa fa-angle-right').attr('aria-hidden', "true");
        $(next_a).append(next_a_i).appendTo(next);
        $('#pagination').append(next);

    }

    $('#pagination').on('click', 'a', function (e) {
        if (this.id != '#') {
            getProduct(this.id);
        }
    });
});
