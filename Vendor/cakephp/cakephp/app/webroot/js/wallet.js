window.addEventListener('DOMContentLoaded', (event) => {

    new Glider(document.querySelector('.glider'), {
        slidesToShow: 1,
        scrollLock: true,
        arrows: {
            prev: '.glider-prev',
            next: '.glider-next'
        }
    });

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const showModal = urlParams.get('showModal');

    if(showModal) {
        var modalText = "<p style='color: red; margin-right: 10px; display: inline-block; font-weight: bold;'>-" + document.querySelector("#hidden2").value + " " + document.querySelector("#hidden1").value + "</p>|<p style='color: #5fd137; margin-left: 10px; display: inline-block; font-weight: bold;'>" + "+" + document.querySelector("#hidden4").value + " " + document.querySelector("#hidden3").value + "</p>";
        Swal.fire({
            icon: 'success',
            title: 'Your balance has changed!',
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
    var cryptoCurrencies = ['BTC', 'ETH', 'XLM', 'XRP', 'LTC', 'EOS', 'YFI'];
    var cryptoFinalValues = document.querySelectorAll(".cryptoBase");
    var resourceValues = document.querySelectorAll(".resourceValue");
    var resourceFinalValues = document.querySelectorAll(".resourceBase");

    calculateCurrencies();
    setCalculationRate();
    calculate();

    select.addEventListener('change', function () {
        calculateWallet();
        calculateCurrencies();
    });

    currencyFrom.addEventListener('change', function () {
        setCalculationRate();
        calculate()
    });

    currencyTo.addEventListener('change', function () {
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

    calculateFrom.addEventListener('keyup', function(e) {
        calculate();
    });

    function calculateCurrencies (onPageLoad) {
        //CURRENCIES
        var chosen = select.options[select.selectedIndex].value;
        req.open('GET', 'https://api.ratesapi.io/api/latest?base='+chosen.toUpperCase(), false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).rates;
        }

        currencies.forEach(function (currency, index) {
            baseValues[index] = (typeof(response[currency.textContent.toUpperCase()]) == 'undefined') ? 1 : response[currency.textContent.toUpperCase()];
            if(currency.textContent == chosen) {
                sameIndex = index;
            }
            index++;
        });

        finalValues.forEach(function (finalValue, index) {
            if(index == sameIndex) {
                finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) * 100) / 100;
            } else if(parseFloat(values[index].innerHTML) > 0) {
                finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) / baseValues[index] * 100) / 100; 
            } else {
                finalValue.innerHTML = 0;
            }
            index++;
        });

        //CRYPTO
        
        req.open('GET', 'https://api.coingecko.com/api/v3/exchange_rates', false);
        req.send(null);
        if(req.status == 200) {
            cryptoResponse = JSON.parse(req.responseText).rates;
        }

        var prices = [];

        for(var i = 0; i < cryptoCurrencies.length; i++) {
            prices[i] = parseFloat(cryptoValues[i].innerHTML) * cryptoResponse[chosen].value / cryptoResponse[cryptoCurrencies[i].toLowerCase()].value;
        }

        cryptoFinalValues.forEach(function (cryptoFinalValue, index) {
            if(parseFloat(cryptoValues[index].innerHTML) > 0) {
                cryptoFinalValue.innerHTML = Math.round(prices[index] * 100) / 100;
            } else {
                cryptoFinalValue.innerHTML = 0;
            }
        });

        //RESOURCES

        req.open('GET', 'https://api.ratesapi.io/api/latest?base=USD', false);
        req.send(null);
        if (req.status == 200) {
            resourcesResponse = JSON.parse(req.responseText).rates;
        }

        var div = document.createElement("div");
        var proxy = 'https://cors-anywhere.herokuapp.com/';

        req.open('GET', proxy + 'https://www.bankier.pl/surowce/notowania', false);
        req.send(null);
        if (req.status == 200) {
            div.innerHTML = req.responseText;
        }

        for(var i = 0; i < 8; i++) {
            resourceFinalValues[i].innerHTML = Math.round(parseFloat(resourceValues[i].innerHTML) * parseFloat(div.getElementsByClassName("colKurs change")[i].innerHTML.trim().replace(",", ".").replace("&nbsp;", "")) * resourcesResponse[chosen.toUpperCase()] * 100) / 100; 
        }

        calculateWallet();
    }

    function setCalculationRate() {
        req.open('GET', 'https://api.ratesapi.io/api/latest?base='+currencyFrom.options[currencyFrom.selectedIndex].value.toUpperCase(), false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).rates;
            var rate = response[currencyTo.options[currencyTo.selectedIndex].value.toUpperCase()];
            rate = Math.floor(rate * 10000) / 10000;
            document.querySelector("span#rate").innerHTML = '1 ' + currencyFrom.options[currencyFrom.selectedIndex].value + ' = ' + rate.toString().replace('.', ',') + ' ' + currencyTo.options[currencyTo.selectedIndex].value;
        }
        return rate;
        
    }

    function calculate() {
        calculateTo.value = parseFloat(calculateFrom.value) * setCalculationRate();
    }

    function calculateWallet () {
        var sum = 0;
        document.querySelectorAll(".base").forEach(function(base) {
            sum += parseFloat(base.textContent.trim());
        })
        document.querySelectorAll(".cryptoBase").forEach(function(cryptoBase) {
            sum += parseFloat(cryptoBase.textContent.trim());
        })
        document.querySelectorAll(".resourceBase").forEach(function(resourceBase) {
            sum += parseFloat(resourceBase.textContent.trim());
        })
        document.querySelector("#sum").innerHTML = lang.wallet_worth + "<b>"+(Math.round(parseFloat(sum) * 100) / 100).toLocaleString()+"</b> "+select.options[select.selectedIndex].value;
        req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/add-to-transaction-history/'+sum, false);
        req.send(null);
    }
    
});