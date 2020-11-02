<?php
    echo $this->Html->css('substract_money');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
?>

<h4>You have withdrawn money from your account</h4>
<p>You will be redirected in <span id="timer">5</span> seconds.</p>
<script>
    var seconds = document.querySelector('#timer');

    setInterval(function () {
        if(parseInt(seconds.innerText) == 1) {
            location.replace("http://localhost/wallency/Vendor/cakephp/cakephp/wallet");
        }
        seconds.innerText = parseInt(seconds.innerText) - 1;
    }, 1000);

</script>
