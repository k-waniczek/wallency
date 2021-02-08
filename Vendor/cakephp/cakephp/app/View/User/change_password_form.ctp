<div class="changePasswordForm">
    <?php

        echo $this->Form->create("changePassword", array("url" => "/change-password"));
        echo $this->Form->input("currentPassword", array("type" => "password"));
        echo $this->Form->input("newPassword", array("type" => "password"));
        echo $this->Form->input("newPasswordConfirm", array("type" => "password"));
        
        echo $this->Form->end("submit");
    ?>
</div>