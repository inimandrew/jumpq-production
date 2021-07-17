$(document).ready(function() {
    'use strict';
       $("#logout").click(function(e){
           e.preventDefault();

           $.ajax({
               url: base_url + "/api/user/logout/",
               type:'GET',
               dataType: "json",
               beforeSend: function(xhr){xhr.setRequestHeader('api_token', api_token);},
               cache: false,

           }).done(function(data){

                    if(data.errors){
                        displayErrors(data.errors,'alert alert-danger');

                    }else if(data.message){
                        displayErrors(data.message,'alert alert-success');

                        document.location.href = base_url+'/sign_in';
                    }




              }).fail(function(){var fail_errors = {
                'errors' : [
                    'An UnExpected Error Occured. Please Reload Page and try again.'
                ]
            };
                displayErrors(fail_errors,'alert alert-warning');

              });


       });

});
