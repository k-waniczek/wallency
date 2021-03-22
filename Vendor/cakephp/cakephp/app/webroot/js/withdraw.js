window.addEventListener("DOMContentLoaded", (event) => {
    var select = document.querySelector("select#WithdrawCurrency");
    var amountInput = document.querySelector("#WithdrawAmount");
    var currency = "usd";
    var response;

    amountInput.value = "";
    document.querySelector("div.submit input").setAttribute("disabled", true);

    currency = select.options[select.selectedIndex].value;
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/wallency/Vendor/cakephp/cakephp/check-money?currency="+currency, false);
    req.send(null);
    if (req.status == 200) {
        response = JSON.parse(req.responseText).Wallet;
        amountInput.setAttribute("max", response[currency]);
        if (response[currency] > 0) {
            amountInput.setAttribute("placeholder", lang.max_withdraw_amount+response[currency]);
        } else {
            amountInput.setAttribute("placeholder", lang.withdraw_amount_none);
        }
    }     

    amountInput.setAttribute("maxlength", response[currency].length);

    amountInput.addEventListener("keyup", function () {
        if (this.value.match(/^[1-9][0-9]{0,}$|^[1-9][0-9]{0,}(\.[0-9]{1,2})$/gm) == null || parseFloat(amountInput.value) < 0 || amountInput.value == "" || parseFloat(amountInput.value) > response[currency]) {
            document.querySelector("div.submit input").setAttribute("disabled", true);
        } else {
            document.querySelector("div.submit input").removeAttribute("disabled");
        }
        if (parseFloat(amountInput.value) > response[currency]) {
            amountInput.value = response[currency];
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
            if (response[currency] > 0) {
                amountInput.setAttribute("placeholder", lang.max_withdraw_amount+response[currency]);
            } else {
                amountInput.setAttribute("placeholder", lang.withdraw_amount_none);
            }
        }     
    });
});
