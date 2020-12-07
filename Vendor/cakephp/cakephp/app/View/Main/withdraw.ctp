<?php

    echo $this->Html->css('withdraw');
    echo $this->Html->css('form');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');


    echo "<div class='withdrawForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9'>";
    echo "<div class='overlay'></div>";
    echo "<h2>".__('withdraw')."</h2>";
    echo $this->Form->create("Withdraw", array("url" => "/substract-money"));
    echo "<div class='col'>";
    echo $this->Form->input("amount", array('type' => 'number', 'max' => 500, 'placeholder' => __('max_withdraw_amount'), 'div' => false, 'label' => __('amount')));
    echo "<span class='focus-border'></span></div>";
    echo $this->Form->input('currency', array('options' => $currencies, 'selected' => 'usd', 'label' => __('currency')));
    echo $this->Form->end(__('withdraw'));
    echo "</div>";

?>

<script>

    var select = document.querySelector('select#WithdrawCurrency');
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
        amountInput.setAttribute('placeholder', "<?php echo __('max_withdraw_amount');?>"+response[currency]);
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
            amountInput.setAttribute('placeholder', 'Max amount you can withdraw is '+response[currency]);
        }     
    });
    

</script>
