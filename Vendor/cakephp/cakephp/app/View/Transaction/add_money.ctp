<?php
    echo $this->Html->css("add_money");
    echo $this->html->script("timer");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>
<h4>You have deposited money to your account</h4>
<p>
    You will be redirected in <span id="timer">5</span> seconds.
</p>
