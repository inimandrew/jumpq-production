$(document).ready(function () {
    'use strict';
    var global_products = new Object();
    var api_route = base_url + "/api/staff/products/null/null";

    fillTable(api_route);

    function actionbuttons(product_id) {
        var button, td, button1;
        button = document.createElement('button');
        button1 = document.createElement('a');
        td = document.createElement('td');

        $(button).attr('data-toogle', 'tooltip').attr('title', 'Delete Product').attr('type', 'button').attr('data-toggle', 'modal').attr('data-target', '#responsive-modal').attr('id', product_id).addClass('btn btn-danger btn-outline btn-circle btn-lg m-r-5 delete').html("<i class='ti ti-trash'></i>");
        $(button1).attr('data-toogle', 'tooltip').attr('title', 'Edit Product').attr('href', base_url + '/staff/edit_product/' + product_id).addClass('btn btn-info btn-outline btn-circle btn-lg m-r-5 edit').html("<i class='fa fa-edit'></i>");
        $(button).appendTo(td);
        $(button1).appendTo(td);

        return td;
    }

    $("#products_data").on("click", ".delete", function (e) {
        $('.modal-title').empty();
        $('.modal-title').html("Are you sure you want to delete " + global_products[this.id] + ' product');
        $('.final_delete').attr('id', this.id);
    });

    $('.final_delete').click(function (e) {
        e.preventDefault();
        $('.final_delete').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Deleting ').prop('disabled', true);

        $.ajax({
            url: base_url + "/api/staff/deleteProduct/" + this.id,
            type: 'GET',
            dataType: "json",
            headers: {
                api_token: api_token
            },
            cache: false,

        }).done(function (data) {
            $('.final_delete').html('Delete').prop('disabled', false);
            $('.close').trigger('click');
            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.message) {
                fillTable(api_route);
                displayErrors(data.message, 'alert alert-success');
            }

        }).fail(function () {
            $('.final_delete').html('Delete').prop('disabled', false);
            $('.close').trigger('click');
            unExpectedError();

        });
    });

    function getProductType(type) {
        var result;
        if (type == 0) {
            result = 'RFID Product'
        } else {
            result = 'Barcode Only Product'
        }

        return result;
    }

    function fillTable(api_route) {
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            headers: {
                api_token: api_token
            },
            cache: false,

        }).done(function (data) {

            if (data.errors) {
                $('#date_picker').text('Submit').prop('disabled', false);
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.data) {
                $("#products_data").empty();
                $('#date_picker').text('Submit').prop('disabled', false);
                var products = data.data;
                var count = data.from;
                jQuery.each(products, function (i, val) {
                    var tr = document.createElement('tr');
                    $(tr).append("<td>" + (count) + "</td>" +
                        "<td>" + val.category_name + "</td>" +
                        "<td>" + val.name + "</td>" +
                        "<td>" + getProductType(val.product_type) + "</td>" +
                        "<td>" + val.quantity + "</td>" +
                        "<td>" + val.currency + val.price + "</td>" +
                        "<td>" + val.currency + val.cost_price + "</td>"
                    ).append(actionbuttons(val.id)).appendTo("#products_data");
                    global_products[val.id] = val.name;
                    count++;
                });

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
                        $(li).addClass('footable-page-arrow active').append($(link).prop('disabled', true)).appendTo('.pagination');
                    } else {
                        if (val == null) {
                            $(link).text(text[i]);
                            $(li).addClass('footable-page-arrow disabled').append($(link).prop('disabled', true)).appendTo('.pagination');
                        } else {
                            $(link).attr('id', i).attr('href', '#' + i).text(text[i]);
                            $(li).addClass('footable-page-arrow').append(link).appendTo('.pagination');
                        }

                    }

                });
            }


        }).fail(function () {
            unExpectedError();

        });
    }

    $(".pagination").on("click", "a", function (event) {
        var index = (this).id;
        var new_api_route = lis[index];
        fillTable(new_api_route);
    });

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
            var new_route = base_url + "/api/staff/products/" + start + "/" + end;
            fillTable(new_route);
            $('#date_picker').text('Submit').prop('disabled', false);

        }
    });



});
