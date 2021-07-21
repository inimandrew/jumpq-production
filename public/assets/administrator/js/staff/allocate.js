$(document).ready(function () {
    'use strict';

    var api_route = base_url + "/api/staff/all_taggable_products";
    var product_data, product;

    getProducts();

    function getProducts() {
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            headers: {
                api_token: api_token
            },
            cache: true,

        }).done(function (data) {

            var products = data;
            if (products.length > 0) {
                jQuery.each(products, function (i, val) {
                    var option = document.createElement('option');
                    $(option).text(val.name + ' - ₦' + val.price).attr('value', val.id);
                    $(option).appendTo('#products');
                });
            }
            $("#products").select2({
                placeholder: "Select a Product",
                allowClear: true,
            }).on('change', function (e) {
                product_data = $('#products').select2('data');

                if (product_data != null) {
                    product = product_data.id;
                } else {
                    product = '';
                }
            });

        }).fail(function () {
            unExpectedError();

        });
    }

    $("#submit").click(function (e) {
        e.preventDefault();
        $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Retrieving Available Tags ').prop('disabled', true);
        $("#allocate-tags :input").prop('disabled', true);

        $.ajax({
            url: base_url + '/api/staff/available_tags',
            type: 'GET',
            dataType: "json",
            headers: {
                api_token: api_token
            },
            cache: false,

        }).done(function (data) {
            $('#submit').html('Allocate Tags').prop('disabled', false);
            $("#allocate-tags :input").prop('disabled', false);

            if (data.available_tags) {
                $('.modal-title').text('You are about to allocate ' + data.available_tags + ' tags to selected product.');
                $('#responsive-modal').modal('show');
            } else if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');
            }
        }).fail(function () {
            $('#submit').html('Allocate Tags').prop('disabled', false);
            $("#allocate-tags :input").prop('disabled', false);
            unExpectedError();
        });
    });

    $("#allocate").click(function (e) {
        e.preventDefault();
        $('#allocate').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Allocating Tags ').prop('disabled', true);
        $("#allocate-tags :input").prop('disabled', true);

        $.ajax({
            url: base_url + '/api/staff/allocate_tags',
            type: 'POST',
            dataType: "json",
            data: {
                'product': product
            },
            headers: {
                api_token: api_token
            },
            cache: false,

        }).done(function (data) {
            $('#allocate').html('Allocate Tags').prop('disabled', false);
            $("#allocate-tags :input").prop('disabled', false);

            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');
                $('#responsive-modal').modal('hide');

            } else if (data.message) {
                displayErrors(data.message, 'alert alert-success');
                $('#responsive-modal').modal('hide');

            }
        }).fail(function () {
            $('#submit').html('Allocate Tags').prop('disabled', false);
            $("#allocate-tags :input").prop('disabled', false);
            $('#responsive-modal').modal('hide');

            unExpectedError();
        });
    });




});
