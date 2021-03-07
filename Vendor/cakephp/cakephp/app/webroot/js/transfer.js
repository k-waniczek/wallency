window.addEventListener("DOMContentLoaded", (event) => {
    var select = document.querySelector("select#transferMoneyCurrencyToSend");
    var usersSelect = document.querySelector("select#transferMoneyUsersList")
    var amountInput = document.querySelector("#transferMoneyAmountToSend");
    var currency = "usd";
    var response;

    usersSelect.addEventListener("change", function () {
        document.querySelector("#transferMoneyRecipientLogin").setAttribute("value", this.options[this.selectedIndex].innerText.replace(/[^-\r\n]+-\h*/, "").replace(" ", ""));
    });

    amountInput.value = "";
    document.querySelector("div.submit input").setAttribute("disabled", true);

    currency = select.options[select.selectedIndex].value;
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/wallency/Vendor/cakephp/cakephp/check-money?currency="+currency, false);
    req.send(null);
    if (req.status == 200) {
        response = JSON.parse(req.responseText).Wallet;
        amountInput.setAttribute("max", response[currency]);
        amountInput.setAttribute("placeholder", lang.max_transfer_amount+response[currency]);
    }     

    amountInput.addEventListener("keyup", function () {
        this.value = this.value.replace(/[^0-9.]/g, "");
        if (parseFloat(amountInput.value) > parseFloat(response[currency])) {
            amountInput.value = parseFloat(response[currency]);
        }
        if (amountInput.value < 0 || amountInput.value == "" || parseFloat(amountInput.value) > parseInt(response[currency])) {
            document.querySelector("div.submit input").setAttribute("disabled", true);
        } else {
            document.querySelector("div.submit input").removeAttribute("disabled");
        }
    });

    select.addEventListener("change", function () {
        currency = select.options[select.selectedIndex].value;
        var req = new XMLHttpRequest();
        req.open("GET", "http://localhost/wallency/Vendor/cakephp/cakephp/check-money?currency="+currency, false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).Wallet;
            amountInput.setAttribute("max", response[currency]);
            amountInput.setAttribute("placeholder", lang.max_transfer_amount+response[currency]);
        }     
    });
});