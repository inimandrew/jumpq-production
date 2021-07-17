const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);

function payWithPaystack() {
    let handler = PaystackPop.setup({
        key: document.getElementById("key").value,
        email: document.getElementById("email").value,
        amount: parseInt(document.getElementById("amount").value * 100),
        firstname: document.getElementById("firstname").value,
        lastname: document.getElementById("lastname").value,
        metadata: {
            transaction_id: document.getElementById("reference").value,
            custom_field: [{
                value: document.getElementById("reference").value,
                display_name: "Transaction ID",
                variable_name: "transaction_id"
            }],
            custom_fields: [{
                value: document.getElementById("reference").value,
                display_name: "Transaction ID",
                variable_name: "transaction_id"
            }],
        },
        transaction_charge: parseInt(Number(document.getElementById("flat_fee").value) * 100),
        currency: 'NGN',
        subaccount: document.getElementById("sub_account").value,
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
