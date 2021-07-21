$(document).ready(function () {
    "use strict";
    var api_route = base_url + "/api/staff/get_products/";
    var cart = [];
    getPaymentTypes();
    var service_charge = Number($('input[name="service_charge"]').val());
    service_charge = (service_charge / 100).toFixed(3);

    function getProduct(barcode) {
        $("input[name='barcode']")
            .prop("disabled", true)
            .text("Retreiving ...");
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
                $("input[name='barcode']").prop("disabled", false).text("Scan");

                if (data.errors) {
                    $("input[name='barcode']").focus();
                    displayErrors(data.errors, "alert alert-danger");
                } else {
                    var products = data;
                    $("input[name='barcode']").focus();

                    products.forEach((product) => {
                        var id = product.id;
                        var type = product.product_type;
                        if ($("#" + id).length == 0) {
                            if (product.product_type == "1") {
                                $("<tr></tr>")
                                    .attr("id", id)
                                    .append(
                                        $("<td></td>").text(product.name),
                                        $("<td></td>")
                                            .text(product.unit_price)
                                            .attr("id", "unit_price-" + id),
                                        $("<td></td>").append(
                                            $("<input>")
                                                .attr("type", "number")
                                                .addClass("form-control")
                                                .attr("id", "quantity-" + id)
                                        ),
                                        $("<td></td>").attr(
                                            "id",
                                            "total-" + id
                                        ),
                                        $("<td></td>").append(
                                            $("<button></button>")
                                                .addClass(
                                                    "btn btn-info btn-outline btn-circle btn-md m-r-5 remove"
                                                )
                                                .val(id)
                                                .append(
                                                    $("<i></i>").addClass(
                                                        "ti-trash"
                                                    )
                                                )
                                        )
                                    )
                                    .appendTo("#cart_details");
                            } else {
                                $("<tr></tr>")
                                    .attr("id", id)
                                    .append(
                                        $("<td></td>").text(product.name),
                                        $("<td></td>")
                                            .text(product.unit_price)
                                            .attr("id", "unit_price-" + id),
                                        $("<td></td>").append(
                                            $("<input>")
                                                .attr("type", "number")
                                                .addClass("form-control")
                                                .attr("id", "quantity-" + id)
                                                .attr("min", 1)
                                                .prop("disabled", true)
                                        ),
                                        $("<td></td>").attr(
                                            "id",
                                            "total-" + id
                                        ),
                                        $("<td></td>").append(
                                            $("<button></button>")
                                                .addClass(
                                                    "btn btn-info btn-outline btn-circle btn-md m-r-5 remove"
                                                )
                                                .val(id)
                                                .append(
                                                    $("<i></i>").addClass(
                                                        "ti-trash"
                                                    )
                                                )
                                        )
                                    )
                                    .appendTo("#cart_details");
                            }

                            changeTotal(
                                product.unit_price,
                                1,
                                barcode,
                                id,
                                type
                            );
                        } else {
                            var old_quantity = Number(
                                $("#quantity-" + id).val()
                            );
                            var quan = old_quantity + 1;
                            changeTotal(
                                product.unit_price,
                                quan,
                                barcode,
                                id,
                                type
                            );
                        }
                    });
                }
            })
            .fail(function () {
                $("input[name='barcode']").prop("disabled", false).text("Scan");
                unExpectedError();
            });
    }
    $("input[name='barcode']").keypress(function (event) {
        $("#led").addClass("blink-bg");
        setInterval(function () {
            $("#led").removeClass("blink-bg");
        }, 1000);

        if (event.which == "10" || event.which == "13") {
            event.preventDefault();
            event.stopImmediatePropagation();

            getProduct($("input[name='barcode']").val());
        }
    });

    $("#rescan").click(function (e) {
        $("input[name='barcode']").val("");
        $("input[name='barcode']").focus();
    });

    $("#cart_details").on("click", ".remove", function (e) {
        $("#" + this.value).remove();
        updateTotal();
        let rr = removeCart(this.value);
    });

    $("#cart_details").on("keyup change", ".form-control", function (e) {
        if (this.value) {
            var split_string = this.id.split("quantity-").join("");
            var old_unit_price = Number(
                $("#unit_price-" + split_string).text()
            );
            var quantity = $("#" + this.id).val();
            var product_type = returnProductType(cart, split_string);
            changeTotal(
                old_unit_price,
                quantity,
                null,
                split_string,
                product_type
            );
        }
    });

    function checkCart(cart, product_id) {
        var result = false;
        jQuery.each(cart, function (i, val) {
            if (val["product_id"] == product_id) {
                result = true;
            }
        });
        return result;
    }

    function removeCart(product_id) {
        cart.forEach((val, i) => {
            if (val["product_id"] == product_id) {
                cart.splice(i, 1);
            }
        });
        return cart;
    }

    function returnProductType(cart, product_id) {
        var result;
        jQuery.each(cart, function (i, val) {
            if (val["product_id"] == product_id) {
                result = val["product_type"];
            }
        });

        return result;
    }

    function checkCodes(cart, code_to_check) {
        var result = false;
        jQuery.each(cart, function (i, val) {
            jQuery.each(val["codes"], function (j, code) {
                if (code == code_to_check) {
                    result = true;
                }
            });
        });
        return result;
    }

    function changeValues(cart, product_id, quantity, total) {
        var result = false;
        jQuery.each(cart, function (i, val) {
            if (val["product_id"] == product_id) {
                val["quantity"] = quantity;
                val["total"] = total;
            }
        });
        return result;
    }

    function updateTotal() {
        const trs = document.querySelectorAll("#cart_details tr");
        let total = 0.0;
        let vat = 0.0;
        let final = 0.0;
        trs.forEach((element) => {
            const index = element.id;
            const price = Number($(`#unit_price-${index}`).text());
            const quantity = Number($(`#quantity-${index}`).val());
            total = total + price * quantity;
        });
        vat = Number(service_charge * total).toFixed(2);
        final = Number(total) + Number(vat);
        $("#sub_total").text(total.toLocaleString());
        $("#vat").text(vat.toLocaleString());
        $("#total").text(final.toLocaleString());
    }

    function addCode(cart, product_id, code) {
        var result = false;
        jQuery.each(cart, function (i, val) {
            if (val["product_id"] == product_id) {
                val["codes"].push(code);
            }
        });
        return result;
    }

    function countCode(cart, product_id) {
        var $result;
        jQuery.each(cart, function (i, val) {
            if (val["product_id"] == product_id) {
                $result = val["codes"].length;
            }
        });

        return $result;
    }

    function changeTotal(
        unit_price,
        new_quantity,
        barcode = null,
        product_id,
        product_type
    ) {
        var new_quantity, tt;

        $("#cart_details tr").each(function () {
            if (checkCart(cart, product_id)) {
                if (product_type == "0") {
                    if (barcode != null) {
                        if (!checkCodes(cart, barcode)) {
                            addCode(cart, product_id, barcode);
                            new_quantity = countCode(cart, product_id);
                            tt = (unit_price * new_quantity).toFixed(2);
                            changeValues(cart, product_id, new_quantity, tt);
                            $("#quantity-" + product_id).val(new_quantity);
                            $("#total-" + product_id).text(tt);
                        } else {
                            var fail_errors = {
                                errors: ["RFID tag has been scanned already"],
                            };
                            displayErrors(fail_errors, "alert alert-danger");
                        }
                    }
                } else {
                    tt = (unit_price * new_quantity).toFixed(2);
                    changeValues(cart, product_id, new_quantity, tt);
                    $("#quantity-" + product_id).val(new_quantity);
                    $("#total-" + product_id).text(tt);
                }
            } else {
                $("#quantity-" + product_id).val(new_quantity);
                $("#total-" + product_id).text(
                    (unit_price * new_quantity).toFixed(2)
                );
                cart.push({
                    quantity: new_quantity,
                    total: $("#total-" + product_id).text(),
                    product_id: product_id,
                    product_type: product_type,
                    codes: [barcode],
                });
            }
        });

        var total = 0.0;

        jQuery.each(cart, function (i, val) {
            total += parseFloat(val["total"]);
        });
        var vat = (total * service_charge).toFixed(2);
        var final = parseFloat(total) + parseFloat(vat);
        $("#sub_total").text(total.toLocaleString());
        $("#vat").text(vat.toLocaleString());
        $("#total").text(final.toLocaleString());
    }

    $("#submit").click(function (e) {
        var name, phone, payment;
        name = $("input[name='name']").val();
        phone = $("input[name='phone']").val();
        payment = $("select[name='payment_type_id']").val();

        if (!name) {
            var fail_errors = {
                errors: ["Customer's Name is required"],
            };
            displayErrors(fail_errors, "alert alert-danger");
        } else if (!phone) {
            var fail_errors = {
                errors: ["Customer's Phone Number is required"],
            };
            displayErrors(fail_errors, "alert alert-danger");
        } else if (!payment) {
            var fail_errors = {
                errors: ["Payment not selected"],
            };
            displayErrors(fail_errors, "alert alert-danger");
        } else if (isEmpty(cart)) {
            var fail_errors = {
                errors: ["No Item Added to Cart"],
            };
            displayErrors(fail_errors, "alert alert-danger");
        } else {
            e.preventDefault();
            $("#submit")
                .html(
                    "<img src=" +
                        base_url +
                        "/assets/general_assets/ajax-loader.gif />&nbsp; Submitting... "
                )
                .prop("disabled", true);
            $.ajax({
                url: base_url + "/api/staff/checkout",
                type: "POST",
                dataType: "json",
                cache: false,
                headers: {
                    api_token: api_token,
                },
                data: {
                    name: name,
                    phone: phone,
                    payment: payment,
                    cart: cart,
                },
            }).done(function (data) {
                $("#submit").html("Clear Payment").prop("disabled", false);
                if (data.errors) {
                    displayErrors(data.errors, "alert alert-danger");
                } else if (data.message) {
                    $("#buyer").trigger("reset");
                    $("#cart_details").empty();
                    $("#sub_total").text(0.0);
                    $("#vat").text(0.0);
                    $("#total").text(0.0);
                    displayErrors(data.message, "alert alert-success");
                }
            });
            $("#submit").text("Clear Payment").prop("disabled", false);
        }
    });

    function getPaymentTypes() {
        $.ajax({
            url: base_url + "/api/payment_types/",
            type: "GET",
            dataType: "json",
            cache: false,
        })
            .done(function (data) {
                var payment_types = data;
                if (payment_types.length > 0) {
                    jQuery.each(payment_types, function (i, val) {
                        var option = document.createElement("option");
                        $(option).text(val.name).attr("value", val.id);
                        $(option).appendTo("#payment_types");
                    });
                }
            })
            .fail(function () {
                unExpectedError();
            });
    }

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) return false;
        }
        return true;
    }
});
