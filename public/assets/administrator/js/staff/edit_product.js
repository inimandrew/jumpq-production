$(document).ready(function() {
    'use strict';

    var product_id = $("meta[name='product_unique_id']").attr('content');
    var category_id,category,types;

    getCategories();
    getProduct();

    function getCategories(){
        $.ajax({
            url: base_url + "/api/categories",
            type:'GET',
            dataType: "json",
            cache: false,

        }).done(function(data){
            var categories = data;
                if(categories.length > 0){
                    jQuery.each(categories, function(i, val) {
                        var option = document.createElement('option');
                        $(option).text(val.name).attr('value',val.id);
                        $(option).appendTo('#categories');
                    });
                }

           }).fail(function(){
        unExpectedError();
     });
    }

    function getProduct(){
        $.ajax({
            url: base_url + "/api/staff/product/"+product_id,
            type:'GET',
            dataType: "json",
            cache: false,
            headers: {
                api_token : api_token
            }

        }).done(function(data){
            var product = data;

            $("input[name='product_name']").val(product.name);
            $("input[name='price']").val(product.price);
            $("input[name='cost_price']").val(product.cost_price);
            $("textarea[name='description']").val(product.description);

            category_id = product.category_id;


        category = $('#categories').find('option');
        jQuery.each(categories, function(i, val) {
            if(val.value != ''){
                if(product.category_id == val.value){
                    $(val).attr('selected','selected');
                }
            }
        });

        types = $('#product_type').find('option');
        jQuery.each(types, function(i, val) {
                if(product.product_type == val.value){
                    $(val).attr('selected','selected');
                }
        });

            $("#categories").select2({
                placeholder: "Select a Category",
                allowClear: true,
            }).on('change',function (e){
                category = $('#categories').select2('data');

                if(category != null){
                    category_id = category.id;
                }else{
                    category = '';
                }
            });


           }).fail(function(){
        unExpectedError();
     });
    }


    $("#update").click(function(e){
        e.preventDefault();
        $('#update').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Submitting ').prop('disabled', true);
        $("#edit-product :input").prop('disabled',true);

        var formData = new FormData();
        formData.append('name', $("input[name='product_name']").val());
        formData.append('category_id', category_id);

        formData.append('product', $("input[name='product']").val());
        formData.append('product_type', $("select[name='product_type']").val());
        formData.append('description', $.trim($("#description").val()));
        formData.append('price', $("input[name='price']").val());
        formData.append('cost_price', $("input[name='cost_price']").val());

        $.ajax({
            url: base_url + "/api/staff/update_product",
            type:'POST',
            dataType: "json",
            data: formData,
            cache: false,
            headers: {
                api_token: api_token
               },
            contentType: false,
            processData: false,

        }).done(function(data){
            $("#edit-product :input").prop('disabled',false);
            $('#update').html('Submit ').prop('disabled', false);
            if(data.errors){
                displayErrors(data.errors,'alert alert-danger');

            }else if(data.message){
                displayErrors(data.message,'alert alert-success');
                window.location.href = base_url+'/staff/products';
                        }


           }).fail(function(){
           $("#edit-product :input").prop('disabled',false);
           $('#update').html('Submit ').prop('disabled', false);

        unExpectedError();
     });

    });
});


