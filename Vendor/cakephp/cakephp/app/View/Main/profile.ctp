<?php

    echo $this->Html->css('profile');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

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

    var currencies = ['USD', 'EUR', 'CHF', 'PLN', 'GBP', 'JPY', 'CAD', 'RUB', 'CNY', 'CZK', 'TRY', 'NOK', 'HUF'];
    var currentRates = "<?php echo(str_replace('"', '\'', json_encode($apiResult))); ?>";
    currentRates = JSON.parse(currentRates.replaceAll('\'', '"'));

    var date = new Date();
    date.setDate(date.getDate()-2);
    var weekend;
    if(date.getDay() == 6 || date.getDay() == 0) {
        weekend = true;
    } else {
        weekend = false;
    }

    function historyApiCall() {
        req.open('GET', 'https://api.ratesapi.io/api/history?start_at='+date.getUTCFullYear()+'-'+(date.getUTCMonth()+1)+'-'+date.getUTCDate()+'&end_at='+date.getUTCFullYear()+'-'+(date.getUTCMonth()+1)+'-'+date.getUTCDate()+'&base='+select.options[select.selectedIndex].value.toUpperCase(), false);
        req.send(null);
        if (req.status == 200) {
            response = JSON.parse(req.responseText);
        }
        return response;
    } 

    var req = new XMLHttpRequest();
    var start = new Date(date.getFullYear(), 0, 0);
    var diff = date - start;
    var oneDay = 1000 * 60 * 60 * 24;
    var day = Math.floor(diff / oneDay);
    if(day % 2 == 0 && weekend == false) {
        historyRates = historyApiCall();
        compare();
    } else {
        date.setDate(date.getDate()-2);
        historyRates = historyApiCall();
        compare();
    }

    function pad(number) {
        return number<10? '0'+number:''+number;
    }

    function compare() {
        var historyRate;
        var lastRate;
        var percent = 0;
        for(var i = 0; i < currencies.length; i++) {
            historyRate = (typeof(historyRates.rates[date.getUTCFullYear()+'-'+pad(date.getUTCMonth()+1)+'-'+pad(date.getUTCDate())][currencies[i]]) == undefined) ? 1 : historyRates.rates[date.getUTCFullYear()+'-'+pad(date.getUTCMonth()+1)+'-'+pad(date.getUTCDate())][currencies[i]];
            lastRate = (currentRates.rates[currencies[i]] == undefined) ? 1 : currentRates.rates[currencies[i]];
            if(lastRate < historyRate * 0.995 || lastRate > historyRate * 1.005) {
                percent = (lastRate / historyRate) * 100 - 100;
                req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/send_currency_change_notification/'+currencies[i]+'/'+Math.round(percent * 100) / 100+'/', false);
                req.send(null);
            }
        }
    }

</script>
