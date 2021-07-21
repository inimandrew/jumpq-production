function makePayment() {
    FlutterwaveCheckout({
        public_key: document.getElementById("key").value,
        tx_ref: document.getElementById("reference").value,
        amount: parseInt(document.getElementById("amount").value),
        currency: "NGN",
        country: "NG",
        payment_options: "card, account, ussd, banktransfer",
        customer: {
            email: document.getElementById("email").value,
            phone_number: document.getElementById("phone").value,
            name: document.getElementById("firstname").value + ' ' + document.getElementById("lastname").value,
        },
        subaccounts: [
            {
              id: document.getElementById("sub_account").value,
              transaction_charge_type: 'flat_subaccount',
              transaction_charge: parseFloat(document.getElementById("total").value),
            },
          ],
        callback: function (data) {
            $('#submit').addClass('hide');
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
            title: "My store",
            description: "Payment for items in cart",
            logo: "https://myjumpq.net/assets/main/JumPQ-logo/default.png",
        },
    });
}
