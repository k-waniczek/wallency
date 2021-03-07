<?php
    echo $this->Html->css("substract_money");
    echo $this->Html->script("timer");
    echo $this->html->css("timer");
    echo $this->html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>

<div class="main">
    <h4>You have withdrawn money from your account</h4>
    <p>
        You will be redirected in <span id="timer">5</span> seconds.
    </p>
</div>

