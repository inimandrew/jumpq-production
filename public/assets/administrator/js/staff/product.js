$(document).ready(function () {
    "use strict";
    getCategories();

    var category;

    $("#categories")
        .select2({
            placeholder: "Select a Category",
            allowClear: true,
        })
        .on("change", function (e) {
            category = $("#categories").select2("data").id;
        });

    function getCategories() {
        $.ajax({
            url: base_url + "/api/categories",
            type: "GET",
            dataType: "json",
            cache: false,
        })
            .done(function (data) {
                var categories = data;
                if (categories.length > 0) {
                    jQuery.each(categories, function (i, val) {
                        var option = document.createElement("option");
                        $(option).text(val.name).attr("value", val.id);
                        $(option).appendTo("#categories");
                    });
                }
                category = "";
            })
            .fail(function () {
                unExpectedError();
            });
    }

    function checkBarcode(barcode) {
        $.ajax({
            url: base_url + "/api/staff/product/barcode/" + barcode,
            type: "GET",
            dataType: "json",
            headers: {
                api_token: api_token,
            },
            cache: false,
        })
            .done(function (data) {
                submitProduct();
            })
            .fail(function () {
                $("#responsive-modal").modal("show");
                console.log(data.errors);
            });
    }

    function submitProduct() {
        $("#submit")
            .html(
                "<img src=" +
                    base_url +
                    "/assets/general_assets/ajax-loader.gif />&nbsp; Submitting "
            )
            .prop("disabled", true);
        $("#add-product :input").prop("disabled", true);

        var photo = $("#images");
        var thumbnail = $("#thumbnail");
        var medium = $("#medium");
        var formData = new FormData();
        var thumbnail_file, medium_file;
        formData.append("_token", $("input[name='_token']").val());
        formData.append("name", $("input[name='product_name']").val());
        formData.append("product_type", $("select[name='product_type']").val());
        formData.append("category_id", category);

        formData.append("description", $.trim($("#description").val()));
        formData.append("price", $("input[name='price']").val());
        formData.append("cost_price", $("input[name='cost_price']").val());
        formData.append("barcode", $("input[name='barcode']").val());

        if (thumbnail[0].files[0] == undefined) {
            thumbnail_file = thumbnail.val();
        } else {
            thumbnail_file = thumbnail[0].files[0];
        }
        formData.append("thumbnail", thumbnail_file);
        if (medium[0].files[0] == undefined) {
            medium_file = medium.val();
        } else {
            medium_file = medium[0].files[0];
        }
        formData.append("medium", medium_file);

        var totalfiles = document.getElementById("images").files.length;
        if (totalfiles > 0) {
            for (var index = 0; index < totalfiles; index++) {
                formData.append("images[]", photo[0].files[index]);
            }
        } else {
            formData.append("images[]", "");
        }

        $.ajax({
            url: base_url + "/api/staff/add_product",
            type: "POST",
            dataType: "json",
            data: formData,
            headers: {
                api_token: api_token,
            },
            contentType: false,
            processData: false,
            cache: false,
        })
            .done(function (data) {
                $("#add-product :input").prop("disabled", false);
                $("#submit").html("Submit").prop("disabled", false);

                if (data.errors) {
                    displayErrors(data.errors, "alert alert-danger");
                } else if (data.message) {
                    displayErrors(data.message, "alert alert-success");
                    $("#add-product").trigger("reset");
                    $("#categories").select2("val", "");
                    $("#payment_types").select2("val", "");
                    $(".dropify-clear").click();
                }
            })
            .fail(function () {
                $("#add-product :input").prop("disabled", false);
                $("#submit").html("Submit").prop("disabled", false);
                unExpectedError();
            });
    }

    $("#submit").click(function (e) {
        e.preventDefault();
        const barcode = $("input[name='barcode']").val();
        if (barcode) {
            checkBarcode(barcode);
        }
    });

    $("#finalSubmit").click(function (e) {
        $("#responsive-modal").modal("hide");
        submitProduct();
    });

    $(":input").keypress(function (event) {
        if (event.which == "10" || event.which == "13") {
            event.preventDefault();
        }
    });

    $("#rescan").click(function (e) {
        $("input[name='barcode']").val("");
        $("input[name='barcode']").focus();
    });
});
