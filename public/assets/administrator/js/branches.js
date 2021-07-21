$(document).ready(function () {
    'use strict';
    var unique_id = $('meta[name="unique_id"]').attr('content');;
    var api_route = base_url + "/api/branches/" + unique_id;

    fillTable(api_route);



    function returnButtons(staffs_url, status, branch_unique_id_) {
        var type, anchor, anchor2, anchor3, commision;
        type = document.createElement('td');
        anchor = document.createElement('a');
        anchor2 = document.createElement('a');
        anchor3 = statusButton(status, branch_unique_id_);

        $(anchor).attr('data-toogle', 'tooltip').attr('title', 'View Staffs').attr('href', staffs_url).addClass('btn btn-primary btn-circle btn-outline btn-lg m-r-5').html("<i class='fa fa-users'></i>");
        $(anchor2).attr('data-toogle', 'tooltip').attr('title', 'Delete Branch').attr('id', branch_unique_id_).addClass('btn btn-danger btn-circle btn-outline btn-lg m-r-5 delete').html("<i class='fa fa-trash'></i>");
        $(anchor).appendTo(type);
        $(anchor2).appendTo(type);
        $(anchor3).appendTo(type);

        return type;
    }

    function statusButton(status, branch_unique_id_) {
        var button;
        button = document.createElement('button');

        if (status == '0') {
            $(button).attr('data-toogle', 'tooltip').attr('title', 'Activate').attr('type', 'button').attr('name', 'activate').attr('id', branch_unique_id_).addClass('btn btn-warning btn-outline btn-circle btn-lg m-r-5 status').html("<i class='ti ti-key'></i>");
        } else if (status == '1') {
            $(button).attr('data-toogle', 'tooltip').attr('title', 'Suspend').attr('type', 'button').attr('name', 'suspend').attr('id', branch_unique_id_).addClass('btn btn-primary btn-outline btn-circle btn-lg m-r-5 status').html("<i class='ti ti-key'></i>");
        } else {
            $(button).attr('data-toogle', 'tooltip').attr('title', 'Unsuspend').attr('type', 'button').attr('name', 'unsuspend').attr('id', branch_unique_id_).addClass('btn btn-success btn-outline btn-circle btn-lg m-r-5 status').html("<i class='ti ti-power-off'></i>");
        }

        return button;
    }

    function status(status) {
        var type;
        type = document.createElement('td');
        if (status == '0') {
            $(type).html("<span class='label label-warning'>" + 'Unactivated' + "</span>");
        } else if (status == '1') {
            $(type).html("<span class='label label-success'>" + 'Active' + "</span>");
        } else {
            $(type).html("<span class='label label-danger'>" + 'Suspended' + "</span>");
        }

        return type;

    }



    function fillTable(api_route) {
        $.ajax({
            url: api_route,
            type: 'GET',
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('api_token', api_token);
            },
            cache: false,

        }).done(function (data) {

            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.data) {
                $("#branches_data").empty();
                var branches = data.data;
                var count = data.from;
                jQuery.each(branches, function (i, val) {
                    var tr = document.createElement('tr');
                    $(tr).append("<td>" + (count) + "</td>" +
                        "<td>" + val.name + "</td>" +
                        "<td>" + val.branch_id + "</td>" +
                        "<td>" + val.staffs_count + "</td>" +
                        "<td>" + val.address + "</td>" +
                        "<td>" + val.phone + "</td>" +
                        "<td>" + val.currency + "</td>" +
                        "<td>" + val.itemMax + "</td>" +
                        "<td>" + val.registered_on + "</td>"
                    ).append(status(val.status)).append(returnButtons(val.staffs_url, val.status, val.unique_id)).appendTo("#branches_data");
                    count++;
                });

                window.lis = {
                    'first': api_route,
                    'prev': data.prev,
                    'content': data.current_page + " / " + data.last_page,
                    'next': data.next,
                    'last': data.last_page_url,
                };
                var text = {
                    'first': "<<",
                    'prev': "<",
                    'next': ">",
                    'last': ">>"
                };
                $('.pagination').empty();
                jQuery.each(lis, function (i, val) {
                    var li = document.createElement('li');
                    var link = document.createElement('a');
                    if (i == "content") {
                        $(link).text(val);
                        $(li).addClass('footable-page-arrow active').append(link).appendTo('.pagination');
                    } else {
                        if (val == null) {
                            $(link).text(text[i]);
                            $(li).addClass('footable-page-arrow disabled').append(link).appendTo('.pagination');
                        } else {
                            $(link).attr('id', i).attr('href', '#' + i).text(text[i]);
                            $(li).addClass('footable-page-arrow').append(link).appendTo('.pagination');
                        }

                    }

                });
            }


        }).fail(function () {

            var fail_errors = {
                'errors': [
                    'An UnExpected Error Occured. Please Reload Page and try again.'
                ]
            };
            displayErrors(fail_errors, 'alert alert-warning');
            $('.print-message-box').fadeIn(1000).delay(4000).fadeOut(1000, function () {
                $(".print-message-box").css('display', 'none');

            });

        });
    }

    $(".pagination").on("click", "a", function (event) {
        var index = (this).id;
        var new_api_route = lis[index];
        fillTable(new_api_route);
    });



    $("#branches_data").on("click", ".status", function (event) {
        var branch = (this).id;
        var action = (this).name;
        $("button").prop('disabled', true);
        $.ajax({
            url: base_url + "/api/branch/change_status",
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('api_token', api_token);
            },
            dataType: "json",
            data: {
                branch_unique_id: branch,
                action: action,
            },
            cache: false,

        }).done(function (data) {

            $("button").prop('disabled', false);
            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.message) {
                displayErrors(data.message, 'alert alert-success');
                fillTable(api_route);
            }
            console.log(data);




        }).fail(function () {
            var fail_errors = {
                'errors': [
                    'An UnExpected Error Occured. Please Reload Page and try again.'
                ]
            };
            displayErrors(fail_errors, 'alert alert-warning');
            $('button').prop('disabled', false);

        });

    });

    $("#branches_data").on('click', '.delete', function (e) {

        e.preventDefault();
        var branch = (this).id;

        $(".delete").prop('disabled', true);
        $.ajax({
            url: base_url + "/api/branch/delete",
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('api_token', api_token);
            },
            dataType: "json",
            data: {
                branch_unique_id: branch,
            },
            cache: false,

        }).done(function (data) {

            $(".delete").prop('disabled', false);
            if (data.errors) {
                displayErrors(data.errors, 'alert alert-danger');

            } else if (data.message) {
                displayErrors(data.message, 'alert alert-success');
                fillTable(api_route);
            }




        }).fail(function () {
            var fail_errors = {
                'errors': [
                    'An UnExpected Error Occured. Please Reload Page and try again.'
                ]
            };
            displayErrors(fail_errors, 'alert alert-warning');
            $('button').prop('disabled', false);

        });

    });

});
