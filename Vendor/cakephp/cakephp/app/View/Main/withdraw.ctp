<?php

echo $this->Form->create("Withdraw", array("url" => "/substract-money"));
echo $this->Form->input("amount", array('type' => 'number', 'max' => 500, 'placeholder' => 'Max'));
echo $this->Form->input('currencies', array('options' => $currencies, 'selected' => 'usd'));
echo $this->Form->end("submit");

?>

<script>

    var select = document.querySelector('select');
    var amountInput = document.querySelector('#WithdrawAmount');
    var currency = 'usd';
    var response;

    amountInput.value = '';

    if(amountInput.value < 0 || amountInput.value == '') {
        document.querySelector('div.submit input').setAttribute('disabled', true);
    }

    currency = select.options[select.selectedIndex].value;
    var req = new XMLHttpRequest();
    req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/check-money?currency='+currency, false);
    req.send(null);
    if (req.status == 200) {
        response = JSON.parse(req.responseText).Wallet;
        amountInput.setAttribute('max', response[currency]);
        amountInput.setAttribute('placeholder', 'Max '+response[currency]);
    }     

    amountInput.addEventListener('keyup', function () {
        if(amountInput.value < 0 || amountInput.value == '' || amountInput.value > response[currency]) {
        document.querySelector('div.submit input').setAttribute('disabled', true);
        } else {
            document.querySelector('div.submit input').removeAttribute('disabled');
        }
    });

    select.addEventListener('change', function () {
        currency = select.options[select.selectedIndex].value;
        var req = new XMLHttpRequest();
        req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/check-money?currency='+currency, false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText).Wallet;
            amountInput.setAttribute('max', response[currency]);
            amountInput.setAttribute('placeholder', 'Max '+response[currency]);
        }     
    });
    

</script>
