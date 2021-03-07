<?php
    echo $this->Html->css("deposit");
    echo $this->Html->css("form");
    echo $this->Html->css("full_page_container_height");
    echo $this->Html->script("deposit");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>
<div class="depositForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9">
    <div class="overlay"></div>
    <h2><?php echo __("deposit");?></h2>
    <?=$this->Form->create("Deposit", array("url" => "/add-money"));?>
        <div class="col">
            <?=$this->Form->input("amount", array("type" => "text", "max" => 500, "placeholder" => __("max_deposit_amount"), "div" => false, "label" => __("amount")));?>
            <span class="focus-border"></span>
        </div>
        <?=$this->Form->input("currency", array("options" => $currencies, "label" => __("currency")));?>
    <?=$this->Form->end(__("deposit_btn"));?>
</div>


