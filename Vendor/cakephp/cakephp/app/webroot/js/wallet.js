window.addEventListener("DOMContentLoaded", (event) => {

    new Glider(document.querySelector(".glider"), {
        slidesToShow: 1,
        scrollLock: true,
        arrows: {
            prev: ".glider-prev",
            next: ".glider-next"
        }
    });

    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var showModal = urlParams.get("showModal");
    var type = urlParams.get("type");

    if (showModal && type == "exchange") {
        var modalText = "<p style=\"color: red; margin-right: 10px; display: inline-block; font-weight: bold;\">-" + urlParams.get("exchangeAmout") + " " + urlParams.get("currencyToExchange") + "</p>|<p style=\"color: #5fd137; margin-left: 10px; display: inline-block; font-weight: bold;\">" + "+" + urlParams.get("buyAmount") + " " + urlParams.get("currencyToBuy") + "</p>";
        Swal.fire({
            icon: "success",
            title: "Your balance has changed!",
            html: modalText,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    } else if(showModal && type == "deposit") {
        var modalText = "<p style=\"color: #5fd137; margin-left: 10px; display: inline-block; font-weight: bold;\">+" + urlParams.get("amountBought") + " " + urlParams.get("currencyBought") + "</p>";
        Swal.fire({
            icon: "success",
            title: "Your balance has changed!",
            html: modalText,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    } else if(showModal && type == "withdraw") {
        var modalText = "<p style=\"color: red; margin-left: 10px; display: inline-block; font-weight: bold;\">-" + urlParams.get("amountSold") + " " + urlParams.get("currencySold") + "</p>";
        Swal.fire({
            icon: "success",
            title: "Your balance has changed!",
            html: modalText,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    } else if(showModal && type == "transfer") {
        var modalText = "<p style=\"color: #5fd137; margin-left: 10px; display: inline-block; font-weight: bold;\">You sent " + urlParams.get("amountSent") + " " + urlParams.get("currencySent") + " to " + urlParams.get("recipientLogin") + "</p>";
        Swal.fire({
            icon: "success",
            title: "Your balance has changed!",
            html: modalText,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    }


    var req = new XMLHttpRequest();
    var response;
    var baseValues = [];
    var select = document.querySelector("#baseValue");
    var values = document.querySelectorAll(".value");
    var currencies = document.querySelectorAll(".currency");
    var finalValues = document.querySelectorAll(".base");
    var changeBtn = document.querySelector("button#change");
    var currencyFrom = document.querySelector("select#currencyFrom");
    var currencyTo = document.querySelector("select#currencyTo");
    var calculateFrom = document.querySelector("input#calculateFrom");
    var calculateTo = document.querySelector("input#calculateTo");
    var sameIndex;
    var cryptoResponse;
    var cryptoValues = document.querySelectorAll(".cryptoValue");
    var cryptoCurrencies = ["BTC", "ETH", "XLM", "XRP", "LTC", "EOS", "YFI"];
    var cryptoFinalValues = document.querySelectorAll(".cryptoBase");
    var resourceValues = document.querySelectorAll(".resourceValue");
    var resourceFinalValues = document.querySelectorAll(".resourceBase");
    var baseCurrencyHeader = document.querySelector("#baseCurrencyHeader");

    baseCurrencyHeader.textContent = lang.base_currency + select.options[select.selectedIndex].value;

    calculateCurrencies();
    setCalculationRate();
    calculate();
    calculateWallet();

    select.addEventListener("change", function () {
        baseCurrencyHeader.textContent = lang.base_currency + select.options[select.selectedIndex].value;
        calculateCurrencies();
        calculateWallet();
    });

    currencyFrom.addEventListener("change", function () {
        setCalculationRate();
        calculate()
    });

    currencyTo.addEventListener("change", function () {
        setCalculationRate();
        calculate()
    });

    changeBtn.addEventListener("click", function () {
        var temp = document.querySelector("select#currencyFrom").selectedIndex;
        document.querySelector("select#currencyFrom").selectedIndex = document.querySelector("select#currencyTo").selectedIndex;
        document.querySelector("select#currencyTo").selectedIndex = temp;
        setCalculationRate();
        calculate();
    });

    calculateFrom.addEventListener("keyup", function(e) {
        this.value = this.value.replace(/[^0-9]/g, "");
        calculate();
    });

    function calculateCurrencies (onPageLoad) {
        //CURRENCIES
        var chosen = select.options[select.selectedIndex].value;
        req.open("GET", "https://api.ratesapi.io/api/latest?base="+chosen.toUpperCase(), false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).rates;
        }

        currencies.forEach(function (currency, index) {
            baseValues[index] = (typeof(response[currency.textContent.toUpperCase()]) == "undefined") ? 1 : response[currency.textContent.toUpperCase()];
            if (currency.textContent == chosen) {
                sameIndex = index;
            }
            index++;
        });

        finalValues.forEach(function (finalValue, index) {
            if (index == sameIndex) {
                finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) * 100) / 100;
            } else if (parseFloat(values[index].innerHTML) > 0) {
                finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) / baseValues[index] * 100) / 100; 
            } else {
                finalValue.innerHTML = 0;
            }
            index++;
        });

        //CRYPTO
        
        req.open("GET", "https://api.coingecko.com/api/v3/exchange_rates", false);
        req.send(null);
        if (req.status == 200) {
            cryptoResponse = JSON.parse(req.responseText).rates;
        }

        var prices = [];

        for(var i = 0; i < cryptoCurrencies.length; i++) {
            prices[i] = parseFloat(cryptoValues[i].innerHTML) * cryptoResponse[chosen].value / cryptoResponse[cryptoCurrencies[i].toLowerCase()].value;
        }

        cryptoFinalValues.forEach(function (cryptoFinalValue, index) {
            if (parseFloat(cryptoValues[index].innerHTML) > 0) {
                cryptoFinalValue.innerHTML = Math.round(prices[index] * 100) / 100;
            } else {
                cryptoFinalValue.innerHTML = 0;
            }
        });

        //RESOURCES

        // req.open("GET", "https://api.ratesapi.io/api/latest?base=USD", false);
        // req.send(null);
        // if (req.status == 200) {
        //     resourcesResponse = JSON.parse(req.responseText).rates;
        // }

        // var div = document.createElement("div");
        // var proxy = "https://cors-anywhere.herokuapp.com/";

        // req.open("GET", proxy + "https://www.bankier.pl/surowce/notowania", false);
        // req.setRequestHeader("origin", "x-requested-with");
        // req.send(null);
        // if (req.status == 200) {
        //     div.innerHTML = req.responseText;
        // }

        // for(var i = 0; i < 8; i++) {
        //     resourceFinalValues[i].innerHTML = Math.round(parseFloat(resourceValues[i].innerHTML) * parseFloat(div.getElementsByClassName("colKurs change")[i].innerHTML.trim().replace(",", ".").replace("&nbsp;", "")) * resourcesResponse[chosen.toUpperCase()] * 100) / 100; 
        // }
    }

    function setCalculationRate() {
        req.open("GET", "https://api.ratesapi.io/api/latest?base="+currencyFrom.options[currencyFrom.selectedIndex].value.toUpperCase(), false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).rates;
            var rate = response[currencyTo.options[currencyTo.selectedIndex].value.toUpperCase()];
            rate = Math.floor(rate * 10000) / 10000;
            document.querySelector("span#rate").innerHTML = "1 " + currencyFrom.options[currencyFrom.selectedIndex].value + " = " + rate.toString().replace(".", ",") + " " + currencyTo.options[currencyTo.selectedIndex].value;
        }
        return rate;
        
    }

    function calculate() {
        calculateTo.value = (Math.round(parseFloat(calculateFrom.value) * setCalculationRate() * 100) / 100);
    }

    function calculateWallet () {
        var sum = 0;
        document.querySelectorAll(".base").forEach(function(base) {
            sum += parseFloat(base.textContent.trim());
        })
        document.querySelectorAll(".cryptoBase").forEach(function(cryptoBase) {
            sum += parseFloat(cryptoBase.textContent.trim());
        })
        // document.querySelectorAll(".resourceBase").forEach(function(resourceBase) {
        //     sum += parseFloat(resourceBase.textContent.trim());
        // })
        req.open("GET", "https://api.ratesapi.io/api/latest?base="+select.options[select.selectedIndex].value.toUpperCase(), false);
        req.send(null);
        if (req.status == 200) {
            var sumInUsd = Math.round(JSON.parse(req.responseText).rates.USD * sum * 100) / 100;
        }
        document.querySelector("#sum").innerHTML = lang.wallet_worth + "<b>"+(Math.round(parseFloat(sum) * 100) / 100).toLocaleString()+"</b> "+select.options[select.selectedIndex].value;
        req.open("GET", "http://localhost/wallency/Vendor/cakephp/cakephp/add-to-transaction-history/"+sumInUsd, false);
        req.send(null);
    }
    
});