<?php

    echo "<div class='exchangeForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9'>";
    echo "<div class='overlay'></div>";
    echo "<h2>".__('exchange')."</h2>";
    echo $this->Form->create("exchangeMoney", array("url" => "exchange"));
    echo "<div class='col'>";
    echo $this->Form->input("amountToBuy", array("type" => "number", "placeholder" => __('max_exchange_amount'), 'div' => false, 'label' => __('amount_to_buy')));
    echo "<span class='focus-border'></span></div>";
    echo $this->Form->input('currencyToExchange', array('options' => $currencies, 'selected' => 'usd', 'label' => __('currency_to_exchange')));
    echo $this->Form->input('currencyToBuy', array('options' => $currencies, 'selected' => 'usd', 'label' => __('currency_to_buy')));

    echo $this->Form->end(__('exchange_btn'), array("class" => "submitBtn"));
    echo "</div>";

    echo $this->Html->css('exchange');
    echo $this->Html->css('form');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');


?>

<script>

    window.addEventListener("DOMContentLoaded", function () {
        var currencies = ['usd', 'eur', 'chf', 'pln', 'gbp', 'jpy', 'cad', 'rub', 'cny', 'try', 'nok', 'huf'];
        var rate;
        var value;

        var submitBtn = document.querySelector("div.submit input");
        var amountInput = document.querySelector("#exchangeMoneyAmountToBuy");
        var exchangeSelect = document.querySelector("#exchangeMoneyCurrencyToExchange");
        var buySelect = document.querySelector("#exchangeMoneyCurrencyToBuy");
        var req = new XMLHttpRequest();

        amountInput.value = '';

        checkInput(amountInput);
        exchange();

        exchangeSelect.addEventListener("change", function () {exchange();});
        buySelect.addEventListener("change", function () {exchange();});
        amountInput.addEventListener("keyup", function () {checkInput(amountInput);});
        amountInput.addEventListener("change", function () {checkInput(amountInput);});
        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();
            var rate = exchange();
            var req = new XMLHttpRequest();
            req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/exchange?currencyToExchange='+exchangeSelect.value+'&exchangeAmout='+(Math.floor((amountInput.value)/rate * 100) / 100)+'&currencyToBuy='+buySelect.value+'&buyAmount='+amountInput.value, false);
            req.send(null);
            if (req.status == 200) {
                window.location = 'http://localhost/wallency/Vendor/cakephp/cakephp/wallet?currencyToExchange='+exchangeSelect.value+'&exchangeAmout='+(Math.floor((amountInput.value)/rate * 100) / 100)+'&currencyToBuy='+buySelect.value+'&buyAmount='+amountInput.value+'&showModal=true';
            }    
            
        });

        function exchange () {
            chosenCurrency = exchangeSelect.options[exchangeSelect.selectedIndex].value;
            req.open('GET', 'https://api.ratesapi.io/api/latest?base='+chosenCurrency.toUpperCase(), false);
            req.send(null);
            if (req.status == 200) {
                rate = JSON.parse(req.responseText).rates[buySelect.options[buySelect.selectedIndex].value.toUpperCase()];
            }
            req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/get-wallet', false);
            req.send();
            if (req.status == 200) {
                value = JSON.parse(req.responseText).Wallet[chosenCurrency];
            }

            amountInput.setAttribute("placeholder", "<?php echo __('max_exchange_amount');?>"+Math.floor(parseFloat(value) * rate * 1) / 1)
            amountInput.setAttribute("max", +Math.floor(parseFloat(value) * rate * 1) / 1)

            return rate;
        }

        function checkInput (input) {
            if(input.value <= 0 || input.value.trim() == '' || input.value > Math.floor(parseFloat(value) * rate * 1) / 1) {
                submitBtn.setAttribute('disabled', true);
            } else {
                submitBtn.removeAttribute("disabled");
            }
        }
    });

    

</script>