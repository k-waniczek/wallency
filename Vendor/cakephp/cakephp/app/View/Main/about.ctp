<?php

    echo $this->Html->css('about');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>
<p>
<?php echo __('about_text')?>
</p>