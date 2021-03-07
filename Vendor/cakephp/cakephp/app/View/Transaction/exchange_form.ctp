<?php
    echo $this->Html->css("exchange");
    echo $this->Html->css("form");
    echo $this->Html->css("full_page_container_height");
    echo $this->Html->script("exchange");

    if ($this->Session->read("language") == "eng") {
        $this->Html->script("lang_en", array("inline" => false));
    } else { 
        $this->Html->script("lang_pl", array("inline" => false));
    }    

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>
<div class="exchangeForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9">
    <div class="overlay"></div>
    <h2><?php echo __("exchange");?></h2>
    <?=$this->Form->create("exchangeMoney", array("url" => "exchange"));?>
        <div class="col">
            <?=$this->Form->input("amountToBuy", array("type" => "text", "placeholder" => __("max_exchange_amount"), "div" => false, "label" => __("amount_to_buy")));?>
            <span class="focus-border"></span>
        </div>
        <?=$this->Form->input("currencyToExchange", array("options" => $currencies, "selected" => "usd", "label" => __("currency_to_exchange")));?>
        <?=$this->Form->input("currencyToBuy", array("options" => $currencies, "selected" => "eur", "label" => __("currency_to_buy")));?>
    <?=$this->Form->end(__("exchange_btn"), array("class" => "submitBtn"));?>
</div>