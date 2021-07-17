$(document).ready(function () {
    'use strict';

    var api_route = base_url + "/api/staff/all_taggable_products";
    var api_route2 = base_url + "/api/staff/unallocated_tags";
    var product_data, product, tags, tag;
    var tags_array = [];

    getProducts();
    getUnAllocateTags();

    function getUnAllocateTags() {
        $.ajax({
            url: api_route2,
            type: 'GET',
            dataType: "json",
            headers: {
                api_token: api_token
            },
            cache: true,

        }).done(function (data) {

            tags = data;
            $('#unallocated_count').text(tags.length);
            $('#tags').empty();
            if (tags.length > 0) {
                jQuery.each(tags, function (i, val) {
                    var option = document.createElement('option');
                    $(option).text(val.rfid).val(val.id);
                    $(option).appendTo('#tags');
                });
                $("#tags").select2({
                    placeholder: "Select Tags",
                    allowClear: true,
                }).on('change', function (e) {
                    tag = $('#tags').select2('data');

                    if (e.added) {
                        tags_array.push(e.added.id);
                    } else if (e.removed) {
                        var filtered = removeItemOnce(tags_array, e.removed.id);
                        tags_array = filtered;
                    }
                });
            }else{
                $("#tags").select2({
                    placeholder: "No Tags Available",
                    allowClear: true,
                });
                $('#tags_inputs').css('display','none');
            }


        }).fail(function () {
            unExpectedError();

        });
    }

    function removeItemOnce(arr, value) {
        var index = arr.indexOf(value);
        if (index > -1) {
            arr.splice(index, 1);
        }
        return arr;
    }

    $('#select_all').click(function (e) {
        if ($(this).is(":checked")) {
            var tags_options = $('#tags').find('option');
            var selected = [];
            jQuery.each(tags_options, function (i, val) {
                if (val.value != '') {
                    selected[selected.length] = val.value;
                }
            });
            tags_array = selected;
            $('#tags').val(selected);
            $('#tags').trigger('change');
        } else if ($(this).is(":not(:checked)")) {
            $('#tags').select2('destroy').find('option').prop('selected', false).end().select2();
            tags_array = [];
        }

    });


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
                    $(option).text(val.name + ' - ₦' + val.price).val(val.id);
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

        if (!product) {
            var fail_errors = {
                'errors': [
                    "Select a Product"
                ]
            };
            displayErrors(fail_errors, 'alert alert-danger');
        } else if (tags_array.length == 0) {
            var fail_errors = {
                'errors': [
                    "Select at least one Tag"
                ]
            };
            displayErrors(fail_errors, 'alert alert-danger');
        } else {
            $('#submit').html('<img src=' + base_url + '/assets/general_assets/ajax-loader.gif />&nbsp; Retrieving Available Tags ').prop('disabled', true);
            $("#allocate-tags :input").prop('disabled', true);
            $.ajax({
                url: base_url + '/api/staff/allocate_tags',
                type: 'POST',
                dataType: "json",
                data: {
                    product: product,
                    tags: tags_array
                },
                headers: {
                    api_token: api_token
                },
                cache: false,

            }).done(function (data) {
                $('#submit').html('Allocate Tags').prop('disabled', false);
                $("#allocate-tags :input").prop('disabled', false);

                if (data.errors) {
                    displayErrors(data.errors, 'alert alert-danger');

                } else if (data.message) {
                    displayErrors(data.message, 'alert alert-success');
                    document.location.href = base_url + '/staff/allocate_tags';

                }
            }).fail(function () {
                $('#submit').html('Allocate Tags').prop('disabled', false);
                $("#allocate-tags :input").prop('disabled', false);
                $('#responsive-modal').modal('hide');

                unExpectedError();
            });
        }

    });



});
