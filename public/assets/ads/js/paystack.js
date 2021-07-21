$(document).ready(function () {
    'use strict';
    function payWithPaystack(context) {
        let handler = PaystackPop.setup({
            key: context.data('key'),
            email: context.data('email'),
            amount: parseInt(context.data('amount') * 100),
            metadata: {
                custom_fields: [{
                    value: context.data('id'),
                    display_name: "Campaign ID",
                    variable_name: "campaign_id"
                }],
            },
            currency: 'NGN',
            onClose: function () {
                alert('Window closed.');
            },
            callback: function (response) {
                let message = 'Payment complete! Reference: ' + response.reference;
                setInterval(function () {
                    window.location = "https://www.myjumpq.net/payment_successful/" + response.reference;
                }, 10000);

            }
        });
        handler.openIframe();
    }

    $('.paystack').click(function(e){
        payWithPaystack($(this))
    })
})
