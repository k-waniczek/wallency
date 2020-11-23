<?php

    echo $this->Html->css("history");
    echo $this->Html->css("table");

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    echo "<div class='limiterHistory col-8k-5 col-4k-5 col-wqhd-5 col-fhd-5 col-hd-5 col-480p-7 col-360p-7 col-sd-8'>";
    echo "<table class='walletHistory'>";
    echo "<thead><tr><th>Type</th><th>Money on plus</th><th>Money on minus</th><th>Transaction date</th></tr></thead>";
    for($i = 0; $i < count($history); $i++) {
        //debug($history[$i]['History']);
        echo "<tr><td>".$history[$i]['History']['type']."</td><td>".$history[$i]['History']['money_on_plus']." ".$history[$i]['History']['currency_plus']."</td><td>".$history[$i]['History']['money_on_minus']." ".$history[$i]['History']['currency_minus']."</td><td>".$history[$i]['History']['transaction_date']."</td></tr>";
    }
    echo "</table>";
    echo "</div>";

?>
<div class="buttons">

</div>
<script>
window.addEventListener('DOMContentLoaded', (event) => {
    var rowCount = "<?php echo $rowCount; ?>";
    for(var i = 0; i < Math.ceil(rowCount / 8); i++) {
        document.querySelector(".buttons").innerHTML += "<button class='btn' data-page='"+(i+1)+"'>"+(i+1)+"</button>";
    }

    var req = new XMLHttpRequest();
    var btns = document.querySelectorAll(".btn");
    var tableBody = document.querySelector("tbody");
    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/get-history-rows/'+btn.dataset.page, false);
            req.send(null);
            if (req.status == 200) {
                response = JSON.parse(req.responseText);
                tableBody.innerHTML = '';
                for(var i = 0; i < response.length; i++) {
                    tableBody.innerHTML += "<tr><td>"+response[i]['History']['type']+"</td><td>"+response[i]['History']['money_on_plus']+" "+response[i]['History']['currency_plus']+"</td><td>"+response[i]['History']['money_on_minus']+" "+response[i]['History']['currency_minus']+"</td><td>"+response[i]['History']['transaction_date']+"</td></tr>";
                }
            }
        });
    });
});

</script>