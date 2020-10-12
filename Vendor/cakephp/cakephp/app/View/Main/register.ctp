<?php

    echo $this->Html->css('register');
    echo $this->Html->css('form');
    echo $this->Html->script('register');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>
<div class="registerForm">
    <div class="overlay"></div>
    <h2>Registration Form</h2>
        <?php

            echo $this->Form->create("RegisterUser", array("url" => "/register-user"));?>
            <div class='col' id="login">
            <?=$this->Form->input("login", array('div' => false, "maxlength" => "16", "size" => "16"));?>
            <span class='focus-border'></span></div>
            <div class='col' id="name">
            <?=$this->Form->input("name", array('div' => false, "minlength" => "3", "maxlength" => "30", "size" => "30"));?>
            <span class='focus-border'></span></div>
            <div class='col' id="surname">
            <?=$this->Form->input("surname", array('div' => false, "minlength" => "3", "maxlength" => "30", "size" => "30"));?>
            <span class='focus-border'></span></div>
            <div class='col' id="email">
            <?=$this->Form->input("email", array('div' => false));?>
            <span class='focus-border'></span></div>
            <div class='col' id="password">
            <?=$this->Form->input("password", array('div' => false, "minlength" => "8", "maxlength" => "30", "size" => "30"));?>
            <span class='focus-border'></span></div>
            <div class='col' id="repeatPassword">
            <?=$this->Form->input("repeatPassword", array('type' => 'password', 'div' => false, "minlength" => "8", "maxlength" => "30", "size" => "30"));?>
            <span class='focus-border'></span></div>
            <div class='col' id="birthDate">
            <?=$this->Form->input('birth_date', array('type' => 'text', 'placeholder' => 'e.g. 2005-06-23', 'div' => false));?>
            <span class='focus-border'></span></div>
            <?=$this->Form->input('baseCurrency', array('options' => $currencies, 'selected' => 'usd'));?>
        <?php

            $this->Form->input('baseCurrency', array('options' => $currencies));
            echo $this->Form->end("Register");

        ?>
</div>