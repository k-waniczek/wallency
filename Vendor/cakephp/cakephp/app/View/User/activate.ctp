<?php

    echo $this->Html->script("timer");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

    if ($alreadyVerified == 0) {
        echo "<h4>Your account have been successfully activated!</h4>";
    } else {
        echo "<h4>Your account is already activated!</h4>";
    }
?>
<p>
    You will be redirected in <span id="timer">5</span> seconds.
</p>
