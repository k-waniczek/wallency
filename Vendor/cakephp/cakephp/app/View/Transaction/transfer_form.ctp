<?php

if ($this->Session->read('language') == 'eng') {
    $this->Html->script('lang_en', array('inline' => false));
} else { 
    $this->Html->script('lang_pl', array('inline' => false));
}    

?>
<div class='transferForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-6 col-360p-8 col-sd-9'>
<div class='overlay'></div>
<h2><?php echo __('transfer');?></h2>
<?php
    echo $this->Form->create("transferMoney", array("url" => "transfer"));
    echo "<div class='col'>";
    echo $this->Form->input("amountToSend", array("type" => "number", "placeholder" => __('max_transfer_amount'), 'div' => false, 'label' => __('amount_to_send')));
    echo "<span class='focus-border'></span></div>";
    for($i = 0; $i < count($usersList); $i++) {
        $usersList[$i] = $usersList[$i]['User']['name']." ".$usersList[$i]['User']['surname']." - ".$usersList[$i]['User']['login'];
    }
    echo $this->Form->input('usersList', array('options' => $usersList, 'label' => __('users_list')));
    echo "<div class='col'>";
    echo $this->Form->input("recipientLogin", array("type" => "text", "placeholder" => __('recipient_login'), 'div' => false, 'label' => __('recipient_login')));
    echo "<span class='focus-border'></span></div>";
    echo $this->Form->input('currencyToSend', array('options' => $currencies, 'selected' => 'usd', 'label' => __('currency_to_send')));
    
    echo $this->Form->end(__('send'), array("class" => "submitBtn"));
    echo "</div>";
    echo $this->Html->css('transferForm');
    echo $this->Html->css('form');
    echo $this->Html->css('full_page_container_height');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');


?>

<script src="app/webroot/js/transfer.js"></script>
<?php
if($this->Session->read('transferError') === true) {
echo "<script>Swal.fire({icon: 'error',text: 'You cannot transfer money to yourself!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
$_SESSION['transferError'] = false;
}?>