$(document).ready(function() {
    'use strict';
    var global_categories = new Object();
    getCategories();
       $("#submit").click(function(e){
           e.preventDefault();
           $('#submit').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Submitting ').prop('disabled', true);
           $("#create-category :input").prop('disabled',true);


           var token = $("input[name='_token']").val();
            var category_name = $("input[name='category_name']").val();

           $.ajax({
               url: base_url + "/api/staff/create_category",
               type:'POST',
               dataType: "json",
               data: {
                   name : category_name,
                   _token : token
               },
               headers: {
                api_token: api_token
               },
               cache: false,

           }).done(function(data){
            $("#create-category").trigger('reset');
            $("#create-category :input").prop('disabled',false);
            $('#submit').html('Submit').prop('disabled', false);

                    if(data.errors){
                        displayErrors(data.errors,'alert alert-danger');

                    }else if(data.message){
                        getCategories();
                        displayErrors(data.message,'alert alert-success');
                    }

              }).fail(function(){
           $("#create-category :input").prop('disabled',false);
           $('#submit').html('Submit').prop('disabled', false);
           unExpectedError();

        });


       });


    function getCategories(){
        $.ajax({
            url: base_url + "/api/categories",
            type:'GET',
            dataType: "json",
            headers: {
             api_token: api_token
            },
            cache: false,

        }).done(function(data){

            $("#category-data").empty();
            var categories = data;
                if(categories.length == 0){
                    var tr = document.createElement('tr');
                    $(tr).append($('<td></td>').text('No Category has been created at this moment').attr('colspan',4)).addClass('emptyCategory').appendTo('#category-data');
                }else{

                    jQuery.each(categories, function(i, val) {
                        global_categories[val.id] = val.name;
                        var tr1 = document.createElement('tr');
                        $(tr1).append('<td>'+(i+1)+'</td>').append('<td>'+val.name+'</td>').append('<td>'+val.products+'</td>')
                        .append(actionbuttons(val.products,val.id));
                        $(tr1).appendTo('#category-data');
                    });
                }

           }).fail(function(){
        unExpectedError();

     });
    }

    function actionbuttons(products_count,product_id){
        var button,td,button1;
        button = document.createElement('button');
        button1 = document.createElement('button');
        td = document.createElement('td');

        if(products_count == 0){
        $(button).attr('data-toogle','tooltip').attr('title','Delete Category').attr('type','button').attr('data-toggle','modal').attr('data-target','#responsive-modal').attr('id',product_id).addClass('btn btn-danger btn-outline btn-circle btn-lg m-r-5 delete').html("<i class='ti ti-trash'></i>");
        $(button1).attr('data-toogle','tooltip').attr('title','Edit Category').attr('type','button').attr('id',product_id).attr('data-toggle','modal').attr('data-target','#editModal').addClass('btn btn-info btn-outline btn-circle btn-lg m-r-5 edit').html("<i class='fa fa-edit'></i>");
        $(button).appendTo(td);
        $(button1).appendTo(td);
       }else if(products_count > 0){
        $(button1).attr('data-toogle','tooltip').attr('title','Edit Category').attr('type','button').attr('id',product_id).attr('data-toggle','modal').attr('data-target','#editModal').addClass('btn btn-info btn-outline btn-circle btn-lg m-r-5 edit').html("<i class='fa fa-edit'></i>").appendTo(td);
    }
       return td;
       }

        $("#category-data").on("click",".delete",function(e){
        $('.delete-title').empty();
        $('.delete-title').html("Are you sure you want to delete " + global_categories[this.id] + ' category');
        $('.final_delete').attr('id',this.id);
   });

   $("#category-data").on("click",".edit",function(e){
    $('#category_name').val(global_categories[this.id]);
    $('.final_edit_submit').attr('id',this.id);
});


    $('.final_delete').click(function(e){
        e.preventDefault();
        $('.final_delete').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Deleting ').prop('disabled', true);

        $.ajax({
            url: base_url + "/api/staff/deletecategory/"+this.id,
            type:'GET',
            dataType: "json",
            headers: {
             api_token: api_token
            },
            cache: false,

        }).done(function(data){
         $('.final_delete').html('Delete').prop('disabled', false);
            $('.close').trigger('click');
                 if(data.errors){
                     displayErrors(data.errors,'alert alert-danger');

                 }else if(data.message){
                     getCategories();
                     displayErrors(data.message,'alert alert-success');
                 }

           }).fail(function(){
        $('.final_delete').html('Delete').prop('disabled', false);
        $('.close').trigger('click');
        unExpectedError();

     });
    });

    $('.final_edit_submit').click(function(e){
        e.preventDefault();
        $('.final_edit_submit').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Updating... ').prop('disabled', true);
        var category_name = $('#category_name').val();

        $.ajax({
            url: base_url + "/api/staff/editCategory/",
            type:'POST',
            dataType: "json",
            data: {
                'id' : this.id,
                'name' : category_name
            },
            headers: {
             api_token: api_token
            },
            cache: false,

        }).done(function(data){
            $('.final_edit_submit').html('Update').prop('disabled', false);
            $('.close').trigger('click');

                 if(data.errors){
                    $('.close').trigger('click');
                     displayErrors(data.errors,'alert alert-danger');

                 }else if(data.message){
                     getCategories();
                     displayErrors(data.message,'alert alert-success');
                 }

           }).fail(function(){
        $('.final_edit_submit').html('Update').prop('disabled', false);
        $('.close').trigger('click');
        unExpectedError();

     });
    });

});
