<?php

    echo $this->Html->css("send_email");
    echo $this->Html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="message">
    <div class="overlay"></div>
    <p><?php echo __("message_sent");?></p>
</div>