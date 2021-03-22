<?php

    echo $this->Html->css("register");
    echo $this->Html->css("form");
    echo $this->Html->script("register");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>
<div class="registerForm col-8k-3 col-4k-3 col-wqhd-3 col-fhd-3 col-hd-3 col-480p-5 col-360p-8 col-sd-10">
    <div class="overlay"></div>
    <h2><?php echo __("registration_form");?></h2>
    <?php echo $this->Form->create("RegisterUser", array("url" => "/register-user"));?>
        <div class="col" id="login">
            <?=$this->Form->input("login", array("div" => false, "maxlength" => "16", "size" => "16", "value" => (!empty($this->Session->read("login"))) ? $this->Session->read("login") : "")); $_SESSION["login"] = "";?>
            <span class="focus-border"></span>
        </div>
        <div class="col" id="name">
            <?=$this->Form->input("name", array("div" => false, "minlength" => "3", "maxlength" => "30", "size" => "30", "label" => __("name"), "value" => (!empty($this->Session->read("name"))) ? $this->Session->read("name") : "")); $_SESSION["name"] = "";?>
            <span class="focus-border"></span>
        </div>
        <div class="col" id="surname">
            <?=$this->Form->input("surname", array("div" => false, "minlength" => "3", "maxlength" => "30", "size" => "30", "label" => __("surname"), "value" => (!empty($this->Session->read("surname"))) ? $this->Session->read("surname") : "")); $_SESSION["surname"] = "";?>
            <span class="focus-border"></span>
        </div>
        <div class="col" id="email">
            <?=$this->Form->input("email", array("div" => false, "value" => (!empty($this->Session->read("email"))) ? $this->Session->read("email") : "")); $_SESSION["email"] = "";?>
            <span class="focus-border"></span>
        </div>
        <div class="col" id="password">
            <?=$this->Form->input("password", array("div" => false, "minlength" => "8", "maxlength" => "30", "size" => "30", "label" => __("password")));?>
            <span class="focus-border"></span>
        </div>
        <div class="col" id="repeatPassword">
            <?=$this->Form->input("repeatPassword", array("type" => "password", "div" => false, "minlength" => "8", "maxlength" => "30", "size" => "30", "label" => __("repeat_password")));?>
            <span class="focus-border"></span>
        </div>
        <div class="col" id="birthDate">
            <?=$this->Form->input("birth_date", array("type" => "text", "placeholder" => "e.g. 1999-06-23", "div" => false, "label" => __("birthdate"), "value" => (!empty($this->Session->read("birthdate"))) ? $this->Session->read("birthdate") : "")); $_SESSION["birthdate"] = "";?>
            <span class="focus-border"></span>
        </div>
        <div class="checkboxCol">
            <?=$this->Form->input("isAdult", array("type" => "checkbox", "div" => false, "label" => __("isAdult")));?>
        </div>
        <?=$this->Form->input("baseCurrency", array("options" => $currencies, "selected" => "usd", "label" => __("base_currency")));?>
        <?= "<div class=\"g-recaptcha\" data-sitekey=\"6Ld7zQMaAAAAAFu1crTri9PJWOyi8ZBndtlHcYk2\"></div>";?>
    <?=$this->Form->end(__("register"));?>
</div>
<?php
if ($this->Session->read("captchaError") == true) {
echo "<script>Swal.fire({icon: \"error\",text: \"Please confirm that you are not a bot, by verifying reCaptcha!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
$_SESSION["captchaError"] = false;
} else if ($this->Session->read("emailError") == true) {
echo "<script>Swal.fire({icon: \"error\",text: \"Please put in a real email address!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
$_SESSION["emailError"] = false;
} else if ($this->Session->read("emailUniqueError") == true) {
echo "<script>Swal.fire({icon: \"error\",text: \"This email is already taken!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
$_SESSION["emailUniqueError"] = false;
}?>


