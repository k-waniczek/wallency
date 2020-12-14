<?php

    echo "<div class='transferForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9'>";
    echo "<div class='overlay'></div>";
    echo "<h2>".__('transfer')."</h2>";
    echo $this->Form->create("transferMoney", array("url" => "transfer"));
    echo "<div class='col'>";
    echo $this->Form->input("amountToSend", array("type" => "number", "placeholder" => __('max_transfer_amount'), 'div' => false, 'label' => __('amount_to_send')));
    echo "<span class='focus-border'></span></div>";
    for($i = 0; $i < count($usersList); $i++) {
        $usersList[$i] = $usersList[$i]['User']['name']." ".$usersList[$i]['User']['surname']." - ".$usersList[$i]['User']['login'];
    }
    echo $this->Form->input('usersList', array('options' => $usersList, 'label' => __('users_list')));
    echo "<div class='col'>";
    echo $this->Form->input("recipientLogin", array("type" => "text", "placeholder" => __('recipient_login'), 'div' => false, 'label' => __('recipient_login')));
    echo "<span class='focus-border'></span></div>";
    echo $this->Form->input('currencyToSend', array('options' => $currencies, 'selected' => 'usd', 'label' => __('currency_to_send')));
    
    echo $this->Form->end(__('send'), array("class" => "submitBtn"));
    echo "</div>";
    echo $this->Html->css('transferForm');
    echo $this->Html->css('form');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');


?>

<script>

    var select = document.querySelector('select#transferMoneyCurrencyToSend');
    var usersSelect = document.querySelector('select#transferMoneyUsersList')
    var amountInput = document.querySelector('#transferMoneyAmountToSend');
    var currency = 'usd';
    var response;

    usersSelect.addEventListener('change', function () {
        document.querySelector("#transferMoneyRecipientLogin").setAttribute('value', this.options[this.selectedIndex].innerText.replace(/[^-\r\n]+-\h*/, '').replace(" ", ""));
    });

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
        amountInput.setAttribute('placeholder', "<?php echo __('max_transfer_amount');?>"+response[currency]);
    }     

    amountInput.addEventListener('keyup', function () {
        if(amountInput.value < 0 || amountInput.value == '' || amountInput.value > parseInt(response[currency])) {
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
            amountInput.setAttribute('placeholder', "<?php echo __('max_transfer_amount');?>"+response[currency]);
        }     
    });

</script>
<?php
if($this->Session->read('transferError') === true) {
echo "<script>Swal.fire({icon: 'error',text: 'You cannot transfer money to yourself!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
$_SESSION['transferError'] = false;
}?>