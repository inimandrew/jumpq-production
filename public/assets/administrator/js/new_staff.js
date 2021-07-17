$(document).ready(function() {
    'use strict';

       $("#submit").click(function(e){
           e.preventDefault();
           $('#submit').html('<img src='+ base_url+'/assets/general_assets/ajax-loader.gif />&nbsp; Submitting ').prop('disabled', true);
           $("#create-store :input").prop('disabled',true);

            var token = $("input[name='_token']").val();
            var branch = $("select[name='branch']").val();
            var role = $("select[name='role']").val();
            var admin_firstname = $("input[name='admin_firstname']").val();
            var admin_lastname = $("input[name='admin_lastname']").val();
            var admin_username = $("input[name='admin_username']").val();
            var admin_email = $("input[name='admin_email']").val();
            var admin_phone = $("input[name='admin_phone']").val();
            var password = $("input[name='password']").val();
            var password_confirmation = $("input[name='password_confirmation']").val();

           $.ajax({
               url: base_url + "/api/store/new_staff",
               type:'POST',
               dataType: "json",
               beforeSend: function(xhr){xhr.setRequestHeader('api_token', api_token);},
               data: {
                branch : branch,
                admin_firstname : admin_firstname,
                admin_lastname : admin_lastname,
                admin_email : admin_email,
                admin_phone : admin_phone,
                admin_username : admin_username,
                role : role,
                password : password,
                password_confirmation : password_confirmation,
                _token : token
               },
               cache: false,

           }).done(function(data){
               scrollToTop();
            $('#submit').html('Submit').prop('disabled', false);
           $("#create-store :input").prop('disabled',false);


                    if(data.errors){
                        displayErrors(data.errors,'alert alert-danger');

                    }else if(data.message){
                        $('#create-branch').trigger('reset');
                        displayErrors(data.message,'alert alert-success');
                    }

              }).fail(function(){
                $('#submit').html('Submit').prop('disabled', false);
                $("#create-store :input").prop('disabled',false);
                var fail_errors = {
                    'errors' : [
                        'An UnExpected Error Occured. Please Reload Page and try again.'
                    ]
                };
                displayErrors(fail_errors,'alert alert-warning');
                   $('#message').fadeIn(1000).delay(4000).fadeOut(1000, function () {
                   $("#message").css('display','none');

               });

              });


       });

});
