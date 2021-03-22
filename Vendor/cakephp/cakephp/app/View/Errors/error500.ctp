<?php
    echo $this->Html->css("full_page_container_height");
    echo $this->Html->css("error");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");
?>
<div class="message">
    <div class="overlay"></div>
    <p><strong>Sorry.</strong> An internal server occured. Please try again later.</p>
</div>
