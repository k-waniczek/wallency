<?php 
if ($alreadyVerified == 0) { ?>
    <h4>Your account have been successfully activated!</h4>
<?php } else {?>
    <h4>Your account is already activated!</h4>
<?php }?>
<p>You will be redirected in <span id="timer">5</span> seconds.</p>
<script>
    var seconds = document.querySelector('#timer');

    setInterval(function () {
        if (parseInt(seconds.innerText) == 1) {
            location.replace("http://localhost/wallency/Vendor/cakephp/cakephp/home");
        }
        seconds.innerText = parseInt(seconds.innerText) - 1;
    }, 1000);

</script>
