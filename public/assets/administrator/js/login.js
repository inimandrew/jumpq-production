$(document).ready(function() {
    'use strict';
        var base_url = $('meta[name="base_url"]').attr('content');

       $("#submit").click(function(e){
           e.preventDefault();
           $('#submit').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Authenticating ').prop('disabled', true);
           $("input[name='username']").prop('disabled',true);
           $("input[name='password']").prop('disabled',true);

           var token = $("input[name='_token']").val();
            var username = $("input[name='username']").val();
            var password = $("input[name='password']").val();

           $.ajax({
               url: base_url + "/api/admin/login",
               type:'POST',
               dataType: "json",
               data: {
                   username : username,
                   password : password,
                   _token : token
               },
               cache: false,

           }).done(function(data){
            $('#submit').html('Login').prop('disabled', false);
            $("input[name='username']").prop('disabled',false);
            $("input[name='password']").prop('disabled',false);
                    if(data.errors){
                        displayErrors(data.errors,'alert alert-danger');

                    }else if(data.message){
                        displayErrors(data.message,'alert alert-success');

                        document.location.href = base_url+'/admin/dashboard';
                    }




              }).fail(function(){

                $("input[name='username']").prop('disabled',false);
                $("input[name='password']").prop('disabled',false);
           var fail_errors = {
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
