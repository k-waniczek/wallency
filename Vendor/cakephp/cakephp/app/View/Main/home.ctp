<?php

    //RODO
    //I agree to the processing of personal data provided in this document for realising the recruitment process pursuant to the Personal Data Protection Act of 10 May 2018 (Journal of Laws 2018, item 1000) and in agreement with Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016 on the protection of natural persons with regard to the processing of personal data and on the free movement of such data, and repealing Directive 95/46/EC (General Data Protection Regulation)


    echo $this->Html->css('home');
    echo $this->Html->script('home');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>

<div id="mainText">
    <h1><strong>Wallency</strong></h1>
    <span class="mainSiteText col-hd-4 col-fhd-4 col-480p-6 col-360p-6 col-sd-8"><?php echo __('home_text');?></span>
</div>

<div class="screenshots">
    <div class="nav">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    <div class="images">
        <?php
            echo $this->Html->image('img1.jpg', array('alt' => 'Image 1', 'class' => 'img1 fade', 'style' => 'opacity: 1'));
            echo $this->Html->image('img2.jpg', array('alt' => 'Image 2', 'class' => 'img2 fade', 'style' => 'opacity: 0'));
            echo $this->Html->image('img3.jpg', array('alt' => 'Image 3', 'class' => 'img3 fade', 'style' => 'opacity: 0'));
        ?>
    </div>
</div>

<div class="chart">
    <canvas id="myChart"></canvas>
    <script>

        var index = 1;
        var data = [];
        var labels = [];
        var ctx = document.getElementById('myChart').getContext('2d');
        var curDate;
        var histData;
        var dateToPush;

        function pad(value) {
            if (value < 10) {
                return '0' + value;
            } else {
                return value;
            }
        }

        var req = new XMLHttpRequest();
        req.open('GET', 'https://min-api.cryptocompare.com/data/v2/histominute?fsym=BTC&tsym=USD&limit=19&aggregate=15&api_key=b76f05d7ae85a73e7992e1044fb1c4b3f07171bfe67a8e21026072f0ac0a26d9', false);
        req.send(null);
        if (req.status == 200) {
            histData = JSON.parse(req.responseText).Data.Data;
            for(var i = 0; i < histData.length; i++) {
                curDate = new Date(histData[i].time * 1000);
                labels[i] = pad(curDate.getHours()) + ":" + pad(curDate.getMinutes());
                data[i] = histData[i].high;
            }
        }

        setInterval(function() {
            if(new Date().getMinutes() == 0 || new Date().getMinutes() == 15 || new Date().getMinutes() == 30 || new Date().getMinutes() == 45) {
                req.open('GET', 'https://min-api.cryptocompare.com/data/v2/histominute?fsym=BTC&tsym=USD&limit=19&aggregate=15&api_key=b76f05d7ae85a73e7992e1044fb1c4b3f07171bfe67a8e21026072f0ac0a26d9', false);
                req.send(null);
                if (req.status == 200) {   
                    histData = JSON.parse(req.responseText).Data.Data;
                    for(var i = 0; i < histData.length; i++) {
                        curDate = new Date(histData[i].time * 1000);
                        labels[i] = pad(curDate.getHours()) + ":" + pad(curDate.getMinutes());
                        data[i] = histData[i].high;
                    }           
                    if (data.length > 20) {
                        // Remove the oldest data and label
                        data.shift();
                        labels.shift();
                    }
                    if(data[19] >= data[18]) {
                        myChart.data.datasets.forEach(function (dataset) {
                            dataset.borderColor = "#00ff00";
                        });
                    } else if (data[19] < data[18]) {
                        myChart.data.datasets.forEach(function (dataset) {
                            dataset.borderColor = "#ff0000";
                        });
                    }
                    myChart.update();
                }
            }
        }, 1000);

        var myChart = new Chart(ctx, {
        "type": "line",
        "data": {
            "labels": labels,
            "datasets": [{
            "label": "<?php echo __('btc_value');?>",
            "data": data,
            "fill": false,
            "borderColor": (data[data.length-1] >= data[data.length-2]) ? "#00ff00" : "#ff0000",
            "lineTension": 0.5
            }]
        },
        "options": {
            "responsive": true,
            "scales": {
            "xAxes": [{
                gridLines: {
                display: false
                },
            }],
            "yAxes": [{
                gridLines: {
                color: "#666666"
                },
            }]
            }
        }
        });
        
    </script>
</div>


