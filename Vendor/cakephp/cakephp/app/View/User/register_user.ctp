<?php

    echo $this->Html->css("send_email");
    echo $this->Html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="message">
    <div class="overlay"></div>
    <p>Your account has been created. Check your email for verification and you'll be able to login.</p>
</div>