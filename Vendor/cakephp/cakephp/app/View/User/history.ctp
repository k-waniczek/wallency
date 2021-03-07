<?php

    echo $this->Html->css("history");
    echo $this->Html->script("history");
    echo $this->Html->css("table");
    if ($this->Session->read("language") == "eng"){
        $this->Html->script("lang_en", array("inline" => false));
    } else { 
        $this->Html->script("lang_pl", array("inline" => false));
    } 

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="limiterHistory">
    <table class="walletHistory">
        <thead>
            <tr>
                <th><?php echo __("type");?></th>
                <th><?php echo __("money_on_plus");?></th>
                <th><?php echo __("money_on_minus");?></th>
                <th><?php echo __("transaction_date");?></th>
            </tr>
        </thead>
        <?php
            for ($i = 0; $i < count($history); $i++) {
                echo "<tr><td>".__($history[$i]["TransactionHistory"]["type"])."</td><td>".$history[$i]["TransactionHistory"]["money_on_plus"]." ".$history[$i]["TransactionHistory"]["currency_plus"]."</td><td>".$history[$i]["TransactionHistory"]["money_on_minus"]." ".$history[$i]["TransactionHistory"]["currency_minus"]."</td><td>".$history[$i]["TransactionHistory"]["transaction_date"]."</td></tr>";
            }
        ?>
    </table>
    <input type="hidden" value="<?=$rowCount?>" id="rowCount"/>
</div>
<div class="buttons"></div>