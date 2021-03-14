<?php
    echo $this->Html->css("add_money");
    echo $this->html->script("timer");
    echo $this->html->css("timer");
    echo $this->html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>
<div class="main">
    <h4>You have deposited money to your account</h4>
    <p>
        You will be redirected in <span id="timer">5</span> seconds.
    </p>
    <input type="hidden" id="link" value="http://localhost/wallency/Vendor/cakephp/cakephp/wallet?amountBought=<?=$amountBought?>&currencyBought=<?=$currencyBought?>&showModal=true&type=deposit"/>
</div>

