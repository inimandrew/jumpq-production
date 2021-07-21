$(document).ready(function () {
    "use strict";

    var api_route = base_url + "/api/staff/get_products/";

    function getProduct(barcode) {
        $("input[name='barcode']").prop("disabled", true);
        $.ajax({
            url: api_route + barcode,
            type: "GET",
            dataType: "json",
            headers: {
                api_token: api_token,
            },
            cache: true,
        })
            .done(function (data) {
                $("input[name='barcode']").val("");
                $("input[name='barcode']").prop("disabled", false);

                if (data.errors) {
                    $("input[name='barcode']").focus();
                    displayErrors(data.errors, "alert alert-danger");
                } else {
                    var products = data;
                    $("#product_details").empty();
                    products.forEach((product, index) => {
                        $("<tr></tr>")
                            .append(
                                $("<td></td>").text(product.name),
                                $("<td></td>").text(product.category_name),
                                $("<td></td>")
                                    .text(product.quantity)
                                    .attr("id", `products-${index}-quantity`),
                                $("<td></td>").append(
                                    $("<input>")
                                        .attr("name", `products-${index}-price`)
                                        .prop("required", true)
                                        .attr("type", "number")
                                        .val(product.unit_price)
                                        .addClass("form-control")
                                ),
                                $("<td></td>").append(
                                    $("<input>")
                                        .attr(
                                            "name",
                                            `products-${index}-cost_price`
                                        )
                                        .prop("required", true)
                                        .attr("type", "text")
                                        .val(product.cost_price)
                                        .addClass("form-control")
                                ),
                                $("<td></td>").append(
                                    $("<input>")
                                        .attr(
                                            "name",
                                            `products-${index}-additional_stock`
                                        )
                                        .prop("required", true)
                                        .attr("type", "number")
                                        .val(0)
                                        .addClass("form-control")
                                ),
                                $("<td></td>").append(
                                    $("<input>")
                                        .attr(
                                            "name",
                                            `products-${index}-reorder`
                                        )
                                        .prop("required", true)
                                        .attr("type", "number")
                                        .val(0)
                                        .addClass("form-control"),
                                    $("<input>")
                                        .attr("name", `products-${index}-id`)
                                        .prop("required", true)
                                        .attr("type", "hidden")
                                        .addClass("form-control")
                                        .val(product.id)
                                )
                            )
                            .appendTo("#product_details");
                    });
                    $("#submit").toggleClass("hide");
                    $("#submit").toggleClass("show");
                }
            })
            .fail(function () {
                $("input[name='barcode']").prop("disabled", false);
                unExpectedError();
            });
    }

    $(":input").keypress(function (event) {
        if (event.which == "10" || event.which == "13") {
            event.preventDefault();
            getProduct($("input[name='barcode']").val());
        }
    });

    // $(document).on('cut copy paste', "input[name='barcode']", function (e) {
    //     e.preventDefault();
    // });

    $("#alternative").click(function (e) {
        e.preventDefault();
        const barcode = $("input[name='barcode']").val();
        if (barcode) {
            getProduct(barcode);
        } else {
            var fail_errors = {
                errors: ["Barcode is Required."],
            };
            displayErrors(fail_errors, "alert alert-danger");
        }
    });

    $("#rescan").click(function (e) {
        $("input[name='barcode']").val("");
        $("input[name='barcode']").focus();
        $("#product_details").empty();
        $("input[name='product_id']").val("");
    });

    $("#submit").click(function (e) {
        e.preventDefault();
        $("#submit")
            .html(
                "<img src=" +
                    base_url +
                    "/assets/general_assets/ajax-loader.gif />&nbsp; Retrieving Available Tags "
            )
            .prop("disabled", true);
        var price, cost_price, additional_stock, quantity, reorder;
        price = $("input[name='price']").val();
        var product_id = $("input[name='product_id']").val();
        cost_price = $("input[name='cost_price']").val();
        additional_stock = Number($("input[name='additional_stock']").val());
        reorder = Number($("input[name='reorder']").val());
        quantity = Number($("#quantity").text());
        var total_quantity = additional_stock + quantity;

        const total = $("#product_details tr").length;
        let isFilled = true;
        let productsRequest = [];
        for (let i = 0; i < total; i++) {
            const id = $(`input[name=products-${i}-id]`).val();
            const price = $(`input[name=products-${i}-price]`).val();
            const cost_price = $(`input[name=products-${i}-cost_price]`).val();
            const reorder = $(`input[name=products-${i}-reorder]`).val();
            const quantity =
                Number($(`input[name=products-${i}-additional_stock]`).val()) +
                Number($(`#products-${i}-quantity`).text());
            let singleProduct = {
                id,
                price,
                cost_price,
                quantity,
                reorder,
            };
            productsRequest.push(singleProduct);
            let values = Object.values(singleProduct);
            const final = values.every((el) => {
                return el;
            });
            isFilled = final;
        }

        if (!isFilled) {
            var fail_errors = {
                errors: ["All Fields are Required."],
            };
            displayErrors(fail_errors, "alert alert-danger");
        } else {
            productUpdate(productsRequest);
        }
        $("#submit").html("Submit").prop("disabled", false);
    });

    function productUpdate(productsParameters) {
        $.ajax({
            url: base_url + "/api/staff/simple_update_product",
            type: "POST",
            dataType: "json",
            data: {
                products: productsParameters,
            },
            cache: false,
            headers: {
                api_token: api_token,
            },
        })
            .done(function (data) {
                $("#submit").html("Submit").prop("disabled", false);
                if (data.errors) {
                    displayErrors(data.errors, "alert alert-danger");
                } else if (data.message) {
                    $("#rescan").trigger("click");
                    displayErrors(data.message, "alert alert-success");
                }
            })
            .fail(function () {
                $("#submit").html("Submit").prop("disabled", false);

                unExpectedError();
            });
    }
});
