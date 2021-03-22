<div class="boxes col-8k-8 col-4k-8 col-wqhd-8 col-fhd-8 col-hd-8 col-480p-9 col-360p-10 col-sd-10">
<?php

    echo $this->Html->css("wallet");
    echo $this->Html->script("wallet");
    echo $this->Html->css("table");

    if ($this->Session->read("language") == "eng"){
        $this->Html->script("lang_en", array("inline" => false));
    }else{ 
        $this->Html->script("lang_pl", array("inline" => false));
    }    

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>
    <div class="limiter glider-contain col-8k-5 col-4k-5 col-wqhd-5 col-fhd-5 col-hd-5 col-480p-10 col-360p-10 col-sd-10">
        <div class="glider">
            <table class="wallet" id="currencyTable">
                <thead>
                    <tr>    
                        <th><?php echo __("currency");?></th>
                        <th><?php echo __("value");?></th>
                        <th id="baseCurrencyHeader"></th>
                    </tr>
                </thead>
                <?php
                    foreach($currencies as $currency) { 
                        echo "<tr><td class=\"currency\">".strtoupper($currency)."".$this->Html->image("flag-".$currency.".png", array("alt" => "flag-".$currency, "class" => "flag"))."</td><td class=\"value\">".(floor(floatval($wallet["Wallet"][$currency]) * 100) / 100)."</td><td class=\"base\"></td></tr>";
                    }
                ?>
            </table>
            <table class="wallet" id="cryptoCurrencyTable">
                <thead>
                    <tr>    
                        <th><?php echo __("crypto_currency");?></th>
                        <th><?php echo __("value");?></th>
                        <th><?php echo __("base_currency");?></th>
                    </tr>
                </thead>
                <?php
                    foreach($cryptoCurrencies as $cryptoCurrency) { 
                        echo "<tr><td class=\"cryptoCurrency\">".ucfirst($cryptoCurrency)."</td><td class=\"cryptoValue\">".(floor(floatval($wallet["Wallet"][$cryptoCurrency]) * 100) / 100)."</td><td class=\"cryptoBase\"></td></tr>";
                    }
                ?>
            </table>
            <table class="wallet" id="resourcesTable">
                <thead>
                    <tr>    
                        <th><?php echo __("resources");?></th>
                        <th><?php echo __("value");?></th>
                        <th><?php echo __("base_currency");?></th>
                    </tr>
                </thead>
                <?php
                    foreach($resources as $resource) { 
                        echo "<tr><td class=\"resource\">".ucfirst(__($resource))."</td><td class=\"resourceValue\">".(floor(floatval($wallet["Wallet"][$resource]) * 100) / 100)."</td><td class=\"resourceBase\"></td></tr>";
                    }
                ?>
            </table>
        </div>
        <button aria-label="Previous" class="glider-prev">«</button>
        <button aria-label="Next" class="glider-next">»</button>
        <div role="tablist" class="dots"></div>
    </div>
    <div class="walletWorth col-8k-4 col-4k-4 col-wqhd-4 col-fhd-4 col-hd-4 col-480p-10 col-360p-10 col-sd-10">
        <select id="baseValue">
            <?php
                foreach($currencies as $currency) {
                    echo "<option value=\"$currency\"".(($currency == $userBaseCurrency) ? "selected=\"selected\"" : "").">".strtoupper($currency)."</option>";
                }
            ?>
        </select>
        <span id="sum"></span>
    </div>

    <div class="currencyCalculator col-8k-4 col-4k-4 col-wqhd-4 col-fhd-4 col-hd-4 col-480p-10 col-360p-10 col-sd-10">
        <h1><?php echo __("currency_calculator");?></h1>
        <div class="calculateFrom">
            <select id="currencyFrom">
                <?php
                    foreach($currencies as $currency) {
                        echo "<option value=\"$currency\">".strtoupper($currency)."</option>";
                    }
                ?>
            </select>
            <input type="string" id="calculateFrom">
        </div>
        <div id="changeAndRate">
            <button id="change">⇅</button>
            <span id="rate"></span>
        </div> 
        <div class="calculateTo">
            <select id="currencyTo">
                <?php
                    foreach($currencies as $currency) {
                        echo "<option value=\"$currency\">".strtoupper($currency)."</option>";
                    }
                ?>
            </select>
            <input type="number" id="calculateTo" disabled>
        </div>
        
    </div>
</div>