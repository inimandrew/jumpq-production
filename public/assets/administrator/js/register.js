$(document).ready(function() {
    'use strict';

       $("#submit").click(function(e){
           e.preventDefault();
           $('#submit').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Submitting ').prop('disabled', true);
           $("#register-admin :input").prop('disabled',true);

           var token = $("input[name='_token']").val();
            var firstname = $("input[name='firstname']").val();
            var lastname = $("input[name='lastname']").val();
            var username = $("input[name='username']").val();
            var email = $("input[name='email']").val();
            var phone = $("input[name='phone']").val();
            var password = $("input[name='password']").val();

           $.ajax({
               url: base_url + "/api/admin/register",
               type:'POST',
               dataType: "json",

               data: {
                   firstname : firstname,
                   lastname : lastname,
                   email : email,
                   phone : phone,
                   username : username,
                   password : password,
                   _token : token
               },
               cache: false,

           }).done(function(data){
            $('#submit').html('Submit').prop('disabled', false);
            $("#register-admin :input").prop('disabled',false);

                    if(data.errors){
                        displayErrors(data.errors,'alert alert-danger');

                    }else if(data.message){
                        $('#register-admin').trigger('reset');
                        displayErrors(data.message,'alert alert-success');
                    }




              }).fail(function(){

                var fail_errors = {
                    'errors' : [
                        'An UnExpected Error Occured. Please Reload Page and try again.'
                    ]
                };
                displayErrors(fail_errors,'alert alert-warning');
                   $('#submit').html('Login').prop('disabled', false);
                   $('#message').fadeIn(1000).delay(4000).fadeOut(1000, function () {
                   $("#message").css('display','none');

               });

              });


       });

});
