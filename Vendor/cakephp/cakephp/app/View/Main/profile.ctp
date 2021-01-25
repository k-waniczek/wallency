<?php

    echo $this->Html->css('profile');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>

<div class="sidebar">
    <h1><?php echo __('hello');?> <?=$this->Session->read("userName");?>!</h1>
    <a href="change-password-form" id="changePassword"><?php echo __('change_password');?></a><br/>
    <?php echo __('change_base_currency');?>
    <select id="baseCurrency">
        <?php
            foreach($currencies as $currency) {
                $selected = ($currency == $this->Session->read("baseCurrency")) ? "selected='selected'" : "";
                echo "<option value='".$currency."' ".$selected.">".$currency."</option>";
            }
        ?>
    </select><br/>
</div>
<div class="chart">
    <canvas id="myChart"></canvas>
</div>
<script>
window.addEventListener('DOMContentLoaded', function() {
    var select = document.querySelector("select#baseCurrency");
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
        return number < 10 ? '0' + number : '' + number;
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

    var index = 1;
    var data = [];
    var labels = [];
    var ctx = document.getElementById('myChart').getContext('2d');
    var curDate;
    var histData;
    var dateToPush;
    var history = <?php echo json_encode($history);?>;

    function pad(value) {
        if (value < 10) {
            return '0' + value;
        } else {
            return value;
        }
    }
    
    for(var i = 0; i < history.length; i++) {
        labels[i] = history[i]['History']['date'];
        data[i] = history[i]['History']['sum'];
    }
    while(data.length > 5) {
        data.shift();
        labels.shift();
    }

    var myChart = new Chart(ctx, {
        "type": "line",
        "data": {
            "labels": labels,
            "datasets": [{
                "label": "Profile worth history",
                "data": data,
                "fill": false,
                "borderColor": (data[data.length-1] >= data[data.length-2]) ? "#00ff00" : "#ff0000",
                "lineTension": 0
            }]
        },
        "options": {
            "responsive": true,
            "scales": {
                "xAxes": [{
                    ticks: {
                        fontColor: "#ffffff"
                    },
                    gridLines: {
                        display: false
                    },
                }],
                "yAxes": [{
                    ticks: {
                        fontColor: "#ffffff"
                    },
                    gridLines: {
                        color: "#ffffff"
                    },
                }]
            }
        }
    });
});

</script>

