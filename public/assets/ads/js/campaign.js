$(document).ready(function () {
    'use strict';
    var selected_plan, start, end;

    function getAssetsAllowed(plan) {
        $.ajax({
            url: base_url + "/assets_allowed/" + plan,
            type: 'GET',
            dataType: "json",
            cache: false,

        }).done(function (data) {
            const asset = data.allowed
            $('select[name="asset_type_id"]').empty()
            asset.forEach((value) => {
                $('select[name="asset_type_id"]').append(
                    $('<option></option>').val(value.id).text(value.type)
                )
            })
        });
    }

    $('select[name="plan_id"]').change(function (e) {
        var plan = $(this).children("option:selected");
        selected_plan = {
            id: plan.val(),
            name: plan.text().trim(),
            price: plan.data('price'),
        }

        if (selected_plan) {
            getAssetsAllowed(selected_plan.id)
        }
        start = $('input[name="start_date"]').val()
        end = $('input[name="end_date"]').val()
        if (start && end && selected_plan) {
            const diff = getDifferenceInDays(start, end)
            getAmount(selected_plan, diff)
        }
    })

    $('select[name="asset_type_id"]').change(function (e) {
        const asset_type = $('select[name="asset_type_id"]').val();

        if (asset_type == 1) {
            $('input[name="asset"]').attr('accept', 'image/*')
        } else if (asset_type == 2) {
            $('input[name="asset"]').attr('accept', 'video/*')
        }
    })


    $('input[name="start_date"],input[name="end_date"]').change(function (e) {
        start = $('input[name="start_date"]').val()
        end = $('input[name="end_date"]').val()

        if (start && end && selected_plan) {
            const diff = getDifferenceInDays(start, end)
            getAmount(selected_plan, diff)
        }
    });

    function getDifferenceInDays(start_date, end_date) {
        const date1 = new Date(start_date)
        const date2 = new Date(end_date)
        const diffTime = Math.abs(date2 - date1)
        const diffDays = Math.ceil((diffTime / (1000 * 60 * 60 * 24)))
        return diffDays
    }

    function getAmount(plan, days) {
        const total = plan.price * days
        $('#total').empty().text(total)
        $('input[name="amount"]').val(total)
    }


})
