$(document).ready(function() {
    'use strict';
        var base_url = $('meta[name="base_url"]').attr('content');

        $.ajax({
            url: base_url + "/api/all_branches",
            type:'GET',
            dataType: "json",
            cache: false,

        }).done(function(data){
            var branches = data.branches;
            
                if(branches.length > 0){
                    var ul = $('<ul></ul>').addClass('single-mega cn-col-4');
                    jQuery.each(branches, function(i, val) {
                        var li = $('<li></li>');
                        var a = $('<a></a>').attr('href',base_url+'/products/'+val.unique_id).text(val.name).appendTo(li);
                        $(li).appendTo(ul);
                        $(ul).appendTo('.megamenu');
                    });

                }
        });

});
