$(document).ready(function() {
    'use strict';
        var api_route =  base_url+"/api/admin/stores";

       fillTable(api_route);



       function returnButtons(branches_url){
        var type,anchor;
        type = document.createElement('td');
        anchor = document.createElement('a');

        $(anchor).attr('data-toogle','tooltip').attr('title','View Branches').attr('href',branches_url).addClass('btn btn-primary btn-circle btn-outline btn-lg m-r-5').html("<i class='mdi mdi-store'></i>");
       $(anchor).appendTo(type);

        return type;
       }



       function fillTable(api_route){
        $.ajax({
            url: api_route,
            type:'GET',
            dataType: "json",
            beforeSend: function(xhr){xhr.setRequestHeader('api_token', api_token);},
            cache: false,

        }).done(function(data){

                 if(data.errors){
                     displayErrors(data.errors,'alert alert-danger');

                 }else if(data.data){
                     $("#stores_data").empty();
                    var stores = data.data;
                    var count = data.from;
                    jQuery.each(stores, function(i, val) {
                        var tr = document.createElement('tr');
                        $(tr).append("<td>" + (count) + "</td>"+
                        "<td>" + stores[i].name +  "</td>"+
                        "<td>" + stores[i].branch_count +  "</td>"+
                        "<td>" + stores[i].registered_on + "</td>").append(returnButtons(stores[i].branches_url)
                        ).appendTo("#stores_data");
                            count++;
                    });

                    window.lis = { 'first' : api_route, 'prev' : data.prev, 'content' : data.current_page+" / "+data.last_page,
                    'next' : data.next, 'last' : data.last_page_url,  };
                    var text = { 'first' : "<<", 'prev' : "<", 'next' : ">", 'last' : ">>"};
                    $('.pagination').empty();
                    jQuery.each(lis, function(i, val) {
                        var li = document.createElement('li');
                        var link = document.createElement('a');
                            if(i == "content"){
                                $(link).text(val);
                                $(li).addClass('footable-page-arrow active').append(link).appendTo('.pagination');
                            }else{
                                if(val == null){
                                    $(link).text(text[i]);
                                    $(li).addClass('footable-page-arrow disabled').append(link).appendTo('.pagination');
                                }else{
                                    $(link).attr('id',i).attr('href','#'+i).text(text[i]);
                                $(li).addClass('footable-page-arrow').append(link).appendTo('.pagination');
                                }

                            }

                    });
                 }


           }).fail(function(){

             var fail_errors = {
             'errors' : [
                 'An UnExpected Error Occured. Please Reload Page and try again.'
             ]
         };
                displayErrors(fail_errors,'alert alert-warning');
                $('.print-message-box').fadeIn(1000).delay(4000).fadeOut(1000, function () {
                $(".print-message-box").css('display','none');

            });

           });
       }

       $(".pagination").on("click", "a", function(event){
           var index = (this).id;
            var new_api_route = lis[index];
            console.log(new_api_route);
            fillTable(new_api_route);
    });



    $("#admin_data").on("click", "button", function(event){
        var user = (this).id;
        var action = (this).name;
        $("button").prop('disabled',true);
        $.ajax({
            url: base_url + "/api/admin/change_status",
            type:'POST',
            beforeSend: function(xhr){xhr.setRequestHeader('api_token', api_token);},
            dataType: "json",
            data: {
                username : user,
                action : action,
            },
            cache: false,

        }).done(function(data){

         $("button").prop('disabled',false);
                 if(data.errors){
                     displayErrors(data.errors,'alert alert-danger');

                 }else if(data.message){
                     displayErrors(data.message,'alert alert-success');
                    fillTable(api_route);
                 }




           }).fail(function(){var fail_errors = {
             'errors' : [
                 'An UnExpected Error Occured. Please Reload Page and try again.'
             ]
         };
         displayErrors(fail_errors,'alert alert-warning');
                $('#submit').html('Login').prop('disabled', false);
                $('.print-message-box').fadeIn(1000).delay(4000).fadeOut(1000, function () {
                $(".print-message-box").css('display','none');

            });

           });

 });

});
