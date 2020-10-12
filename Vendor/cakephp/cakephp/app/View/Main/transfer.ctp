<?php 

    echo $this->Html->css('transfer');
    echo $this->Html->css('form');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');


    if($this->Session->read("dbError") == true) {
        echo "<h4>".$this->Session->read("dbError")."</h4>";
    } else {
        echo "<h4>Your money has been transfered!</h4>";
    }
?>
<p>You will be redirected in <span id="timer">5</span> seconds.</p>
<script>
    var seconds = document.querySelector('#timer');

    setInterval(function () {
        if(parseInt(seconds.innerText) == 1) {
            location.replace("http://localhost/wallency/Vendor/cakephp/cakephp/home");
        }
        seconds.innerText = parseInt(seconds.innerText) - 1;
    }, 1000);

</script>