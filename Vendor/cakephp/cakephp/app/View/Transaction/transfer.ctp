<?php 

    echo $this->Html->css("transfer");
    echo $this->Html->css("form");
    echo $this->Html->script("timer");
    echo $this->html->css("timer");
    echo $this->html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>

<div class="main">
    <?php
        if ($this->Session->read("dbError") == true) {
            echo "<h4>".$this->Session->read("dbError")."</h4>";
        } else {
            echo "<h4>Your money has been transfered!</h4>";
        }
    ?>
    <p>
        You will be redirected in <span id="timer">5</span> seconds.
    </p>
    <input type="hidden" id="link" value="http://localhost/wallency/Vendor/cakephp/cakephp/wallet?amountSent=<?=$amountSent?>&currencySent=<?=$currencySent?>&recipientLogin=<?=$recipientLogin?>&showModal=true&type=transfer"/>
</div>
    