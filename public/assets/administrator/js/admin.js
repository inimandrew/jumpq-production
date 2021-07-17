$(document).ready(function() {
    'use strict';
        var api_route =  base_url+"/api/admin/admins/";

       fillTable(api_route);

       function adminType(role){
           var type;
            type = document.createElement('td');
           if(role == '0'){
                $(type).html("<span class='label label-danger'>"+'Super-Administrator'+"</span>");
           }else{
                $(type).html("<span class='label label-primary'>"+'Administrator'+"</span>");
        }

        return type;

       }

       function returnButton(status,user){
        var type,button;
        type = document.createElement('td');
        button = document.createElement('button');
       if(status == '0'){
            $(button).attr('data-toogle','tooltip').attr('title','Activate User').attr('type','button').attr('name','activate').attr('id',user).addClass('btn btn-warning btn-outline btn-circle btn-lg m-r-5').html("<i class='ti ti-key'></i>");
       }else if(status == '1'){
        $(button).attr('data-toogle','tooltip').attr('title','Suspend User').attr('type','button').attr('name','suspend').attr('id',user).addClass('btn btn-primary btn-outline btn-circle btn-lg m-r-5').html("<i class='ti ti-key'></i>");
       }else{
        $(button).attr('data-toogle','tooltip').attr('title','Unsuspend User').attr('type','button').attr('name','unsuspend').attr('id',user).addClass('btn btn-success btn-outline btn-circle btn-lg m-r-5').html("<i class='ti ti-power-off'></i>");
       }
       $(button).appendTo(type);

    return type;
       }

       function status(status){
        var type;
         type = document.createElement('td');
        if(status == '0'){
             $(type).html("<span class='label label-warning'>"+'Not Activated'+"</span>");
        }else if(status == '1'){
             $(type).html("<span class='label label-success'>"+'Active'+"</span>");
        }else{
            $(type).html("<span class='label label-danger'>"+'Suspended'+"</span>");

        }

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

                     $("#admin_data").empty();
                    var admins = data.data;
                    var count = data.from;
                    jQuery.each(admins, function(i, val) {

                        var tr = document.createElement('tr');
                        $(tr).append("<td>" + (count) + "</td>"+
                        "<td>" + val.firstname + ' ' + val.lastname + "</td>"+
                        "<td>" + val.email + "</td>"+
                        "<td>" + val.username + "</td>"+
                        "<td>" + val.phone + "</td>").append(adminType(val.role)).append(status(val.status)).append(
                        "<td>" + val.created_at + "</td>"
                        ).append(returnButton(val.status,val.username)).appendTo("#admin_data");
                            count++;
                    });

                    window.lis = { 'first' : base_url+'/api/admin/admins/', 'prev' : data.prev, 'content' : data.current_page+" / "+data.last_page,
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

           });

 });

});
