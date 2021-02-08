<?php

    if ($this->Session->read("language") == "eng") {
        $this->Html->script("lang_en", array("inline" => false));
    } else { 
        $this->Html->script("lang_pl", array("inline" => false));
    }    

    echo $this->Html->css("withdraw");
    echo $this->Html->css("form");
    echo $this->Html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>
<div class="withdrawForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9">
    <div class="overlay"></div>
    <h2><?php echo __("withdraw");?></h2>
    <?php
        echo $this->Form->create("Withdraw", array("url" => "/substract-money"));
        echo "<div class=\"col\">";
        echo $this->Form->input("amount", array("type" => "number", "max" => 500, "placeholder" => __("max_withdraw_amount"), "div" => false, "label" => __("amount")));
        echo "<span class=\"focus-border\"></span></div>";
        echo $this->Form->input("currency", array("options" => $currencies, "selected" => "usd", "label" => __("currency")));
        echo $this->Form->end(__("withdraw_btn"));
    ?>
</div>

<script src="app/webroot/js/withdraw.js"></script>
