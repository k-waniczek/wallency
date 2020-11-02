<?php

    echo $this->Html->css('profile');
    echo $this->Html->css('table');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    echo "<div class='limiter'>";
    echo "<table class='wallet'>";
    echo "<thead><tr><th>Currency</th><th>Value</th><th>Base currency</th></tr></thead>";
    $sum = 0;
    foreach($currencies as $currency) {
        $amount = ($currency == $this->Session->read("baseCurrency")) ? $wallet['Wallet'][$currency] : round(($wallet['Wallet'][$currency]) / $apiResult['rates'][strtoupper($currency)], 2);
        echo "<tr><td class='currency'>".$currency."</td><td class='value'>".$wallet['Wallet'][$currency]."</td><td class='base'>".$amount."</td></tr>";
        $sum += $amount;
    }
    echo "</table>";
    echo "</div>";

?>

<div class="sidebar">
    <h1>Hello, <?=$this->Session->read("userName");?>!</h1>
    <a href="change-password-form" id="changePassword">Change Password</a><br/>
    Change your base currency: 
    <select id="baseCurrency">
        <?php
            foreach($currencies as $currency) {
                $selected = ($currency == $this->Session->read("baseCurrency")) ? "selected='selected'" : "";
                echo "<option value='".$currency."' ".$selected.">".$currency."</option>";
            }
        ?>
    </select><br/>
    <span id="walletSum">Your wallet is worth: <?=$sum." ".$this->Session->read("baseCurrency");?> </span>
</div>
<canvas id="canvas" width="375" height="375" style="float: right;"></canvas>
<script>
    var select = document.querySelector("select#baseCurrency");
	var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");
    ctx.scale(0.75,0.75);

    ctx.strokeStyle = '#00ffff';
    ctx.lineWidth = 17;
    ctx.shadowBlur = 15;
    ctx.shadowColor = '#00ffff'

    function degToRad(degree) {
        var factor = Math.PI / 180;
        return degree * factor;
    }

    function renderTime() {
        var now = new Date();
        var today = now.toDateString();
        var time = now.toLocaleTimeString();
        var hrs = now.getHours();
        var min = now.getMinutes();
        var sec = now.getSeconds();
        var mil = now.getMilliseconds();
        var smoothsec = sec + (mil / 1000);
        var smoothmin = min + (smoothsec / 60);

        //Background
        ctx.fillStyle = '#0e2633';
        ctx.fillRect(0, 0, 500, 500);
        //Hours
        ctx.beginPath();
        ctx.arc(250, 250, 200, degToRad(270), degToRad((hrs * 30) - 90));
        ctx.stroke();
        //Minutes
        ctx.beginPath();
        ctx.arc(250, 250, 170, degToRad(270), degToRad((smoothmin * 6) - 90));
        ctx.stroke();
        //Seconds
        ctx.beginPath();
        ctx.arc(250, 250, 140, degToRad(270), degToRad((smoothsec * 6) - 90));
        ctx.stroke();
        //Date
        ctx.font = "25px Helvetica";
        ctx.fillStyle = 'rgba(00, 255, 255, 1)'
        ctx.fillText(today, 175, 250);
        //Time
        ctx.font = "25px Helvetica Bold";
        ctx.fillStyle = 'rgba(00, 255, 255, 1)';
        ctx.fillText(time + ":" + mil, 175, 280);

    }
    setInterval(renderTime, 40); 

    select.addEventListener('change', function () {
        var currency = select.options[select.selectedIndex].value;
        var req = new XMLHttpRequest();
        req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/change-base-currency?currency='+currency, false);
        req.send(null);
        if (req.status == 200) {
            Swal.fire({
                icon: 'success',
                title: 'Your base currency has changed to ' + currency + '!',
                text: 'Please login to see changes.',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                onClose: () => {window.location = "http://localhost/wallency/Vendor/cakephp/cakephp/logout"}
            });
        }
    });

</script>
