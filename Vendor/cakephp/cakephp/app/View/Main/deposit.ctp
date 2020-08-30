<?php

echo $this->Form->create("Deposit", array("url" => "/add-money"));
echo $this->Form->input("amount", array('type' => 'number', 'max' => 500, 'placeholder' => 'Max 500'));
echo $this->Form->input('currencies', array('options' => $currencies));
echo $this->Form->end("submit");

?>

<script>

    var amountInput = document.querySelector('#DepositAmount');

    amountInput.value = '';

    if(amountInput.value < 0 || amountInput.value == '') {
        document.querySelector('div.submit input').setAttribute('disabled', true);
    }


    amountInput.addEventListener('keyup', function () {
        if(amountInput.value < 0 || amountInput.value == '' || amountInput.value > 500) {
        document.querySelector('div.submit input').setAttribute('disabled', true);
        } else {
            document.querySelector('div.submit input').removeAttribute('disabled');
        }
    });
</script>
