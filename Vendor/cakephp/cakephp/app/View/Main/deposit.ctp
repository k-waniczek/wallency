<?php
    echo "<div class='depositForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9'>";
    echo "<div class='overlay'></div>";
    echo "<h2>".__('deposit')."</h2>";
    echo $this->Form->create("Deposit", array("url" => "/add-money"));
    echo "<div class='col'>";
    echo $this->Form->input("amount", array('type' => 'number', 'max' => 500, 'placeholder' => __('max_deposit_amount'), 'div' => false, 'label' => __('amount')));
    echo "<span class='focus-border'></span></div>";
    echo $this->Form->input('currency', array('options' => $currencies, 'label' => __('currency')));
    echo $this->Form->end(__('deposit'));
    echo "</div>";

    echo $this->Html->css('deposit');
    echo $this->Html->css('form');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
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
