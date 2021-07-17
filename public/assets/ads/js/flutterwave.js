$(document).ready(function () {
    'use strict';
    function makePayment(context) {
        FlutterwaveCheckout({
            public_key: context.data('key'),
            tx_ref: Math.floor((Math.random() * 1000000000) + 1),
            amount: parseInt(context.data('amount')),
            currency: "NGN",
            country: "NG",
            payment_options: "card, account, ussd, banktransfer",
            customer: {
                email: context.data('email').trim(),
                name: context.data('name').trim(),
            },
            callback: function (data) {
                $('.flutter').addClass('hide').css('display','hidden');
                var fail_errors = {
                    'errors': [
                        "You will be Redirected for Verification soon"
                    ]
                };
                displayErrors(fail_errors, 'alert alert-success');
                setInterval(function () {
                    window.location = "https://www.myjumpq.net/payment_successful/" + document.getElementById("reference").value;
                }, 3000);
            },
            onclose: function () {

            },
            customizations: {
                title: "Ads Payment",
                description: "Payment for Ads",
                logo: "https://myjumpq.net/assets/main/JumPQ-logo/default.png",
            },
        });
    }


    $('.flutter').click(function(e){
        makePayment($(this))
    })
})
