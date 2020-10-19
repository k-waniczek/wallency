<?php
    echo "<div class='depositForm'>";
    echo "<div class='overlay'></div>";
    echo "<h2>Deposit</h2>";
    echo $this->Form->create("Deposit", array("url" => "/add-money"));
    echo "<div class='col'>";
    echo $this->Form->input("amount", array('type' => 'number', 'max' => 500, 'placeholder' => 'Max 500', 'div' => false));
    echo "<span class='focus-border'></span></div>";
    echo $this->Form->input('currencies', array('options' => $currencies));
    echo $this->Form->end("submit");
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