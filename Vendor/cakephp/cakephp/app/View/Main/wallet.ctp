<div class="boxes col-8k-8 col-4k-8 col-wqhd-8 col-fhd-8 col-hd-8 col-480p-9 col-360p-10 col-sd-10">
<?php

    echo $this->Html->css('wallet');
    echo $this->Html->script('wallet');
    echo $this->Html->css('table');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    echo "<div class='limiter glider-contain col-8k-5 col-4k-5 col-wqhd-5 col-fhd-5 col-hd-5 col-480p-10 col-360p-10 col-sd-10'>";
        echo "<div class='glider'>";
            echo "<table class='wallet' id='table1'>";
            echo "<thead><tr><th>Currency</th><th>Value</th><th>Base currency</th></tr></thead>";
            foreach($currencies as $currency) { 
                echo "<tr><td class='currency'>".$currency."<img src='https://www.countryflags.io/".substr($currency, 0, -1)."/shiny/64.png' class='flag'/></td><td class='value'>".(floor(floatval($wallet['Wallet'][$currency]) * 100) / 100)."</td><td class='base'></td></tr>";
            }
            echo "</table>";
            echo "<table class='wallet' id='table2'>";
            echo "<thead><tr><th>Crypto Currency</th><th>Value</th><th>Base currency</th></tr></thead>";
            foreach($cryptoCurrencies as $cryptoCurrency) { 
                echo "<tr><td class='cryptoCurrency'>".$cryptoCurrency."</td><td class='cryptoValue'>".(floor(floatval($wallet['Wallet'][$cryptoCurrency]) * 100) / 100)."</td><td class='cryptoBase'></td></tr>";
            }
            echo "</table>";
            echo "<table class='wallet' id='table3'>";
            echo "<thead><tr><th>Resources</th><th>Value</th><th>Base currency</th></tr></thead>";
            foreach($resources as $resource) { 
                echo "<tr><td class='currency'>".$resource."</td><td class='value'>".(floor(floatval($wallet['Wallet'][$resource]) * 100) / 100)."</td><td class='base'></td></tr>";
            }
            echo "</table>";
        echo "</div>";
        echo "<button aria-label='Previous' class='glider-prev'>«</button>";
        echo "<button aria-label='Next' class='glider-next'>»</button>";
        echo "<div role='tablist' class='dots'></div>";
    echo "</div>";

    if(!empty($this->params['url'])) {
        $currencyToExchange = $this->params['url']['currencyToExchange'];
        $exchangeAmout = $this->params['url']['exchangeAmout'];
        $currencyToBuy = $this->params['url']['currencyToBuy'];
        $buyAmount = $this->params['url']['buyAmount'];

        echo "<input type='hidden' id='hidden1' value='$currencyToExchange'>";
        echo "<input type='hidden' id='hidden2' value='$exchangeAmout'>";
        echo "<input type='hidden' id='hidden3' value='$currencyToBuy'>";
        echo "<input type='hidden' id='hidden4' value='$buyAmount'>";
    }

    // echo "<table border='1'>";
    // for($i = 0; $i < count($cryptoCurrencies); $i++) {  
    //     echo "<tr><td>".$cryptoCurrencies[$i]."</td><td>".$wallet['Wallet'][$cryptoCurrencies[$i]]."</td></tr>";
    // }
    // echo "</table><br/>";

    // echo "<table border='1'>";
    // for($i = 0; $i < count($resources); $i++) {  
    //     echo "<tr><td>".$resources[$i]."</td><td>".$wallet['Wallet'][$resources[$i]]."</td></tr>";
    // }
    // echo "</table>";

?>


    <div class="walletWorth col-8k-4 col-4k-4 col-wqhd-4 col-fhd-4 col-hd-4 col-480p-10 col-360p-10 col-sd-10">
        <select id="baseValue">
        <?php
            foreach($currencies as $currency) {
                echo "<option value='".$currency."'>".$currency."</option>";
            }
        ?>
        </select>
        <span id="sum">Your wallet is worth: </span>
    </div>

    <div class="currencyCalculator col-8k-4 col-4k-4 col-wqhd-4 col-fhd-4 col-hd-4 col-480p-10 col-360p-10 col-sd-10">
        <div class="calculateFrom">
            <select id="currencyFrom">
            <?php
                foreach($currencies as $currency) {
                    echo "<option value='".$currency."'>".strtoupper($currency)."</option>";
                }
            ?>
            </select>
            <input type="number" id="calculateFrom">
        </div>
        <div class="changeAndRate">
            <button class="change">⇅</button>
            <span id="rate"></span>
        </div> 
        <div class="calculateTo">
            <select id="currencyTo">
            <?php
                foreach($currencies as $currency) {
                    echo "<option value='".$currency."'>".strtoupper($currency)."</option>";
                }
            ?>
            </select>
            <input type="number" id="calculateTo" disabled>
        </div>
        
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {

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

        // NORMAL CURRENCIES

        var req = new XMLHttpRequest();
        var response;
        var baseValues = [];
        var index = 0;
        var select = document.querySelector("#baseValue");
        var values = document.querySelectorAll(".value");
        var currencies = document.querySelectorAll(".currency");
        var finalValues = document.querySelectorAll(".base");
        var changeBtn = document.querySelector("button.change");
        var currencyFrom = document.querySelector("select#currencyFrom");
        var currencyTo = document.querySelector("select#currencyTo");
        var calculateFrom = document.querySelector("input#calculateFrom");
        var calculateTo = document.querySelector("input#calculateTo");
        var sameIndex;
        var sum = 0;
        req.open('GET', 'https://api.ratesapi.io/api/latest?base=USD', false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).rates;
        }

        calculateWalletSum();
        setCalculationRate();
        calculate()

        select.addEventListener('change', function () {
            calculateWalletSum();
        });

        currencyFrom.addEventListener('change', function () {
            setCalculationRate();
            calculate()
        });

        currencyTo.addEventListener('change', function () {
            setCalculationRate();
            calculate()
        });

        currencies.forEach(function (currency, index) {
            baseValues[index] = response[currency.textContent.toUpperCase()];
            index++;
        });

        finalValues.forEach(function (finalValue, index) {
            if(parseFloat(values[index].innerHTML) > 0) {
                finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) / baseValues[index] * 100) / 100;
            } else {
                finalValue.innerHTML = 0;
            }
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

        function calculateWalletSum() {
            document.querySelector("#sum").innerHTML = 'Your wallet is worth: ';
            sum = 0;
            chosen = select.options[select.selectedIndex].value;
            req.open('GET', 'https://api.ratesapi.io/api/latest?base='+chosen.toUpperCase(), false);
            req.send(null);
            if (req.status == 200) {
                response = JSON.parse(req.responseText).rates;
            }

            currencies.forEach(function (currency, index) {
                baseValues[index] = response[currency.textContent.toUpperCase()];
                if(currency.innerHTML == chosen) {
                    sameIndex = index;
                }
                index++;
            });

            finalValues.forEach(function (finalValue, index) {

                if(index == sameIndex) {
                    finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) * 100) / 100;
                    sum += Math.round(parseFloat(values[index].innerHTML) * 100) / 100;
                } else if(parseFloat(values[index].innerHTML) > 0) {
                    finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) / baseValues[index] * 100) / 100;
                    sum += Math.round(parseFloat(values[index].innerHTML) / baseValues[index] * 100) / 100;
                } else {
                    finalValue.innerHTML = 0;
                }
                
                index++;
            });
            document.querySelector("#sum").innerHTML += "<b>"+(Math.round(sum * 100)/100)+"</b> "+chosen;
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

        // CRYPTO CURRENCIES

        var req = new XMLHttpRequest();
        var cryptoResponse;
        var cryptoBaseValues = [];
        var cryptoValues = document.querySelectorAll(".cryptoValue");
        var cryptoCurrencies = ['BTC', 'ETH', 'USDT', 'XRP', 'LTC', 'EOS', 'XTZ'];
        var cryptoFinalValues = document.querySelectorAll(".cryptoBase");
        var sameIndex;

        for(var i = 0; i < cryptoCurrencies.length; i++) {
            req.open('GET', 'https://min-api.cryptocompare.com/data/v2/histominute?fsym='+cryptoCurrencies[i]+'&tsym=USD&limit=1&api_key=b76f05d7ae85a73e7992e1044fb1c4b3f07171bfe67a8e21026072f0ac0a26d9', false);
            req.send(null);
            if (req.status == 200) {
                cryptoResponse = JSON.parse(req.responseText);
                cryptoBaseValues[i] = cryptoResponse.Data.Data[1].close;
            }
        }

        cryptoFinalValues.forEach(function (cryptoFinalValue, index) {
            if(parseFloat(cryptoValues[index].innerHTML) > 0) {
                cryptoFinalValue.innerHTML = Math.round(parseFloat(cryptoValues[index].innerHTML) * cryptoBaseValues[index] * 100) / 100;
            } else {
                cryptoFinalValue.innerHTML = 0;
            }
        });

        changeBtn.addEventListener("click", function () {
            var temp = currencyFrom.selectedIndex;
            currencyFrom.selectedIndex = currencyTo.selectedIndex;
            currencyTo.selectedIndex = temp;
            setCalculationRate();
            calculate()
        });

        calculateFrom.addEventListener('keyup', function(e) {
            calculate();
        });

        //RESOURCES

        var req = new XMLHttpRequest();
        var resourceResponse;
        var resourceBaseValues = [];
        var resourceValues = document.querySelectorAll(".resourceValue");
        var resourceFinalValues = document.querySelectorAll(".resourceBase");
        var sameIndex;
        

    });

</script>