<div class="boxes">
<?php

echo $this->Html->css('wallet');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

echo "<div class='limiter'>";
echo "<table>";
echo "<thead><tr><th>Currency</th><th>Value</th><th>Base currency</th></tr></thead>";
for($i = 0; $i < count($currencies); $i++) {  
    echo "<tr><td class='currency'>".$currencies[$i]."</td><td class='value'>".$wallet['Wallet'][$currencies[$i]]."</td><td class='base'></td></tr>";
}
echo "</table>";
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


    <div class="walletWorth">
        <select id="baseValue">
        <?php
            for($i = 0; $i < count($currencies); $i++) {  
                echo "<option value='".$currencies[$i]."'>".$currencies[$i]."</option>";
            }
        ?>
        </select>
        <span id="sum">Your wallet is worth: </span>
    </div>

    <div class="someBox">

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
            })
        }

        var req = new XMLHttpRequest();
        var response;
        var baseValues = [];
        var index = 0;
        var select = document.querySelector("#baseValue");
        var values = document.querySelectorAll(".value");
        var currencies = document.querySelectorAll(".currency");
        var finalValues = document.querySelectorAll(".base");
        var sameIndex;
        var sum = 0;
        req.open('GET', 'https://api.ratesapi.io/api/latest?base=USD', false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).rates;
        }

        calculateWalletSum()

        select.addEventListener('change', function () {
            calculateWalletSum()
        });

        currencies.forEach(function (currency, index) {
            baseValues[index] = response[currency.innerHTML.toUpperCase()];
            index++;
        });

        finalValues.forEach(function (finalValue, index) {
            if(parseFloat(values[index].innerHTML) > 0) {
                finalValue.innerHTML = Math.round(parseFloat(values[index].innerHTML) / baseValues[index] * 100) / 100;
            } else {
                finalValue.innerHTML = 0;
            }
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
                baseValues[index] = response[currency.innerHTML.toUpperCase()];
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
            document.querySelector("#sum").innerHTML += (Math.round(sum * 100)/100)+" "+chosen;
        }

    });

</script>
