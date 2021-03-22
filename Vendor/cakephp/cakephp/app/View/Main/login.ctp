<?php

    echo $this->Html->css("login");
    echo $this->Html->script("login");
    echo $this->Html->css("form");
    echo $this->Html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="loginForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-5 col-360p-8 col-sd-10">
    <div class="overlay"></div>
    <h2><?php echo __("login_form");?></h2>
        <?php echo $this->Form->create("LoginUser", array("url" => "/login-user"));?>
        <div class="col">
            <?php echo $this->Form->input("loginOrEmail", array("div" => false, "label" => __("login_or_email")));?>
            <span class="focus-border"></span>
        </div>
        <div class="col">
            <?php echo $this->Form->input("password", array("div" => false, "label" => __("password")));?>
            <i class="fas fa-eye"></i>
            <span class="focus-border"></span>
        </div>
    <?php echo $this->Form->end(__("login"));?>
</div>
<?php
if ($this->Session->read("loginError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"Wrong login credentials!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["loginError"] = false;
} else if ($this->Session->read("verificationError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"You have to verify your account first!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["verificationError"] = false;
}
?>