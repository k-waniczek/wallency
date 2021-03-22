<?php

    echo $this->Html->css("change_password");
    echo $this->Html->css("form");
    echo $this->Html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="changePasswordForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-5 col-360p-8 col-sd-10">
    <div class="overlay"></div>
    <h2><?php echo "Change password form";?></h2>
    <?=$this->Form->create("changePassword", array("url" => "/change-password"));?>
        <div class="col">
            <?=$this->Form->input("currentPassword", array("type" => "password", "div" => false, "label" => "Current password"));;?>
            <span class="focus-border"></span>
        </div>
        <div class="col">
            <?=$this->Form->input("newPassword", array("type" => "password", "div" => false, "label" => "New password"));?>
            <span class="focus-border"></span>
        </div>
        <div class="col">
            <?=$this->Form->input("newPasswordConfirm", array("type" => "password", "div" => false, "label" => "New password confirm"));?>
            <span class="focus-border"></span>
        </div>
    <?=$this->Form->end("Change");?>
</div>
<script>
    document.querySelector("#changePasswordNewPassword").addEventListener("mouseenter", function () {
        swal = Swal.mixin({
            toast: true,
            text: "New password must contain at least: 1 big letter, 1 special character, 1 number and needs to be at least 8 characters long.",
            showConfirmButton: false,
            showClass: {
                popup: '',
                icon: ''
            },
            hideClass: {
                popup: '',
            }
        })
        swal.fire();
    });
    document.querySelector("#changePasswordNewPassword").addEventListener("mouseleave", function () {
        swal.close();
    });
</script>
<?php
if ($this->Session->read("passwordChanged") == true) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Your password has been changed! You'll be now logged out.\",showConfirmButton: true,timer: 5000,timerProgressBar: true, onClose: () => { window.location.replace(\"http://localhost/wallency/Vendor/cakephp/cakephp/logout\"); }});</script>";
    $_SESSION["passwordChanged"] = false;
} else if ($this->Session->read("passwordRegexError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"New password must contain at least: 1 big letter, 1 special character and 1 number.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["passwordRegexError"] = false;
} else if ($this->Session->read("oldPasswordError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"Your current password is wrong.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["oldPasswordError"] = false;
} else if ($this->Session->read("passwordMatchError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"New passwords doesn't match.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["passwordMatchError"] = false;
}

?>