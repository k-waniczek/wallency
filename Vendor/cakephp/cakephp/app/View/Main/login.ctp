<div class="loginForm">
<br/>
<?php

    echo $this->Form->create("LoginUser", array("url" => "/login-user"));
    echo $this->Form->input("loginOrEmail");
    echo $this->Form->input("password");
    
    echo $this->Form->end("submit");

    echo $this->Flash->render('loginError');

?>
</div>