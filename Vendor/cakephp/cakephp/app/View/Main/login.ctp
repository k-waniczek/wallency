<?php

    echo $this->Html->css('login');
    echo $this->Html->css('form');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>

<div class="loginForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-5 col-360p-8 col-sd-10">
    <div class="overlay"></div>
    <h2>Login Form</h2>
    <?php

        echo $this->Form->create("LoginUser", array("url" => "/login-user"));
        echo "<div class='col'>";
        echo $this->Form->input("loginOrEmail", array('div' => false));
        echo "<span class='focus-border'></span></div>";
        echo "<div class='col'>";
        echo $this->Form->input("password", array('div' => false));
        echo "<span class='focus-border'></span></div>";
        
        echo $this->Form->end("submit");

        echo $this->Flash->render('loginError');

    ?>
</div>