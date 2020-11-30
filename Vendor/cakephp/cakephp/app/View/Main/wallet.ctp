<div class="boxes col-8k-8 col-4k-8 col-wqhd-8 col-fhd-8 col-hd-8 col-480p-9 col-360p-10 col-sd-10">
<?php

    echo $this->Html->css('wallet');
    echo $this->Html->script('wallet');
    echo $this->Html->css('table');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    echo "<div class='limiter glider-contain col-8k-5 col-4k-5 col-wqhd-5 col-fhd-5 col-hd-5 col-480p-10 col-360p-10 col-sd-10'>";
        echo "<div class='glider'>";
            echo "<table class='wallet' id='table1'>";
            echo "<thead><tr><th>".__('currency')."</th><th>".__('value')."</th><th>".__('base_currency')."</th></tr></thead>";
            foreach($currencies as $currency) { 
                echo "<tr><td class='currency'>".strtoupper($currency)."".$this->Html->image("flag-".$currency.".png", array('alt' => "flag-".$currency, 'class' => 'flag'))."</td><td class='value'>".(floor(floatval($wallet['Wallet'][$currency]) * 100) / 100)."</td><td class='base'></td></tr>";
            }
            echo "</table>";
            echo "<table class='wallet' id='table2'>";
            echo "<thead><tr><th>".__('crypto_currency')."</th><th>".__('value')."</th><th>".__('base_currency')."</th></tr></thead>";
            foreach($cryptoCurrencies as $cryptoCurrency) { 
                echo "<tr><td class='cryptoCurrency'>".$cryptoCurrency."</td><td class='cryptoValue'>".(floor(floatval($wallet['Wallet'][$cryptoCurrency]) * 100) / 100)."</td><td class='cryptoBase'></td></tr>";
            }
            echo "</table>";
            echo "<table class='wallet' id='table3'>";
            echo "<thead><tr><th>".__('resources')."</th><th>".__('value')."</th><th>".__('base_currency')."</th></tr></thead>";
            foreach($resources as $resource) { 
                echo "<tr><td class='resource'>".$resource."</td><td class='resourceValue'>".(floor(floatval($wallet['Wallet'][$resource]) * 100) / 100)."</td><td class='resourceBase'></td></tr>";
            }
            echo "</table>";
        echo "</div>";
        echo "<button aria-label='Previous' class='glider-prev'>«</button>";
        echo "<button aria-label='Next' class='glider-next'>»</button>";
        echo "<div role='tablist' class='dots'></div>";
    echo "</div>";

    if(!empty($this->params['url'])) {
        $currencyToExchange = $this->params['url']['currencyToExchange'];
        $exchangeAmout = $this->params['url']['exchangeAmout'];
        $currencyToBuy = $this->params['url']['currencyToBuy'];
        $buyAmount = $this->params['url']['buyAmount'];

        echo "<input type='hidden' id='hidden1' value='$currencyToExchange'>";
        echo "<input type='hidden' id='hidden2' value='$exchangeAmout'>";
        echo "<input type='hidden' id='hidden3' value='$currencyToBuy'>";
        echo "<input type='hidden' id='hidden4' value='$buyAmount'>";
    }

    // echo "<table border='1'>";
    // for($i = 0; $i < count($cryptoCurrencies); $i++) {  
    //     echo "<tr><td>".$cryptoCurrencies[$i]."</td><td>".$wallet['Wallet'][$cryptoCurrencies[$i]]."</td></tr>";
    // }
    // echo "</table><br/>";

    // echo "<table border='1'>";
    // for($i = 0; $i < count($resources); $i++) {  
    //     echo "<tr><td>".$resources[$i]."</td><td>".$wallet['Wallet'][$resources[$i]]."</td></tr>";
    // }
    // echo "</table>";

?>


    <div class="walletWorth col-8k-4 col-4k-4 col-wqhd-4 col-fhd-4 col-hd-4 col-480p-10 col-360p-10 col-sd-10">
        <select id="baseValue">
        <?php
            foreach($currencies as $currency) {
                echo "<option value='".$currency."'>".strtoupper($currency)."</option>";
            }
        ?>
        </select>
        <span id="sum"></span>
    </div>

    <div class="currencyCalculator col-8k-4 col-4k-4 col-wqhd-4 col-fhd-4 col-hd-4 col-480p-10 col-360p-10 col-sd-10">
        <div class="calculateFrom">
            <select id="currencyFrom">
            <?php
                foreach($currencies as $currency) {
                    echo "<option value='".$currency."'>".strtoupper($currency)."</option>";
                }
            ?>
            </select>
            <input type="number" id="calculateFrom">
        </div>
        <div class="changeAndRate">
            <button class="change">⇅</button>
            <span id="rate"></span>
        </div> 
        <div class="calculateTo">
            <select id="currencyTo">
            <?php
                foreach($currencies as $currency) {
                    echo "<option value='".$currency."'>".strtoupper($currency)."</option>";
                }
            ?>
            </select>
            <input type="number" id="calculateTo" disabled>
        </div>
        
    </div>
</div>