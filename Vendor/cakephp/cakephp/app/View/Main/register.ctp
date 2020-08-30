<div class="registerForm">
<?php

    echo $this->Form->create("RegisterUser", array("url" => "/register-user"));
    echo $this->Form->input("login");
    echo $this->Form->input("name");
    echo $this->Form->input("surname");
    echo $this->Form->input("email");
    echo $this->Form->input("password");
    echo $this->Form->input("repeatPassword", array('type' => 'password'));
    echo $this->Form->input('birth_date', array('type' => 'text', 'placeholder' => 'e.g. 2005-06-23'));    
    echo $this->Form->input('baseCurrency', array('options' => $currencies));
    
    echo $this->Form->end("submitRegister");

?>
</div>