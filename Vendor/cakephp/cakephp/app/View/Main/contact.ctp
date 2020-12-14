<?php

    echo $this->Html->css('contact');
    echo $this->Html->script('contact');
    echo $this->Html->css('form');
    echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>

<div class="contactForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-5 col-360p-8 col-sd-10">
    <div class="overlay"></div>
    <h2><?php echo __('contact_form');?></h2>
    <?php

        echo $this->Form->create("Contact", array("url" => "/send-email"));
        echo "<div class='col'>";
        echo $this->Form->input("emailFrom", array('div' => false, 'label' => __('your_email')));
        echo "<span class='focus-border'></span></div>";
        echo "<div class='col'>";
        echo $this->Form->input("senderName", array('div' => false, 'label' => __('your_name')));
        echo "<span class='focus-border'></span></div>";
        echo "<div class='col'>";
        echo "<span class='messageLength'></span>";
        echo $this->Form->input("message", array('div' => false, 'type' => 'textarea', 'rows' => 6, 'label' => __('message'), 'maxlength' => 200));
        echo "<span class='focus-border'></span></div>";
        echo "<div class='g-recaptcha' data-sitekey='6Ld7zQMaAAAAAFu1crTri9PJWOyi8ZBndtlHcYk2'></div>";
        
        echo $this->Form->end(__('send'));
    ?>
</div>
<?php
if($this->Session->read('captchaError') === true) {
echo "<script>Swal.fire({icon: 'error',text: 'Please confirm that you are not a bot, by verifying reCaptcha!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
$_SESSION['captchaError'] = false;
}?>