<?php

    echo $this->Html->css("history");
    echo $this->Html->css("table");
    if ($this->Session->read("language") == "eng"){
        $this->Html->script("lang_en", array("inline" => false));
    } else { 
        $this->Html->script("lang_pl", array("inline" => false));
    } 

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="limiterHistory col-8k-5 col-4k-5 col-wqhd-5 col-fhd-5 col-hd-5 col-480p-7 col-360p-7 col-sd-8">
    <table class="walletHistory">
        <thead>
            <tr>
                <th><?php echo __("type");?></th>
                <th><?php echo __("money_on_plus");?></th>
                <th><?php echo __("money_on_minus");?></th>
                <th><?php echo __("transaction_date");?></th>
            </tr>
        </thead>
        <?php
            for ($i = 0; $i < count($history); $i++) {
                echo "<tr><td>".__($history[$i]["TransactionHistory"]["type"])."</td><td>".$history[$i]["TransactionHistory"]["money_on_plus"]." ".$history[$i]["TransactionHistory"]["currency_plus"]."</td><td>".$history[$i]["TransactionHistory"]["money_on_minus"]." ".$history[$i]["TransactionHistory"]["currency_minus"]."</td><td>".$history[$i]["TransactionHistory"]["transaction_date"]."</td></tr>";
            }
        ?>
    </table>
</div>
<div class="buttons"></div>
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var rowCount = "<?php echo $rowCount; ?>";
        var btnsDiv = document.querySelector(".buttons");
        if (Math.ceil(rowCount / 8) <= 5) {
            for(var i = 0; i < Math.ceil(rowCount / 8); i++) {
                btnsDiv.innerHTML += "<button class=\"btn\" data-page=\""+(i+1)+"\">"+(i+1)+"</button>";
            }
        } else {
            for(var i = 0; i < 3; i++) {
                btnsDiv.innerHTML += "<button class=\"btn\" data-page=\""+(i+1)+"\">"+(i+1)+"</button>";
            }
            btnsDiv.innerHTML += "<button class=\"btn\">...</button>";
            btnsDiv.innerHTML += "<button class=\"btn\" data-page=\""+(Math.ceil(rowCount / 8))+"\">"+(Math.ceil(rowCount / 8))+"</button>";
        }

        var req = new XMLHttpRequest();
        var type;
        var btns = document.querySelectorAll("[data-page]");
        var tableBody = document.querySelector("tbody");
        btns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                addButtons(btn);
            });
        });

        function addButtons(btn) {
            btns = document.querySelectorAll("[data-page]");
            if (Math.ceil(rowCount / 8) > 5) {
                btnsDiv.innerHTML = "";
                if (parseInt(btn.dataset.page) > 3) {
                    btnsDiv.innerHTML += "<button class=\"btn\" data-page=\"1\">1</button>";
                    btnsDiv.innerHTML += "<button class=\"btn\">...</button>";
                }
                for(var i = parseInt(btn.dataset.page) - 2; i <= parseInt(btn.dataset.page) + 2; i++) {
                    if (i > 0 && i <=  Math.ceil(rowCount / 8)) {
                        btnsDiv.innerHTML += "<button class=\"btn\" data-page=\""+(i)+"\">"+(i)+"</button>";
                    }
                }
                if (parseInt(btn.dataset.page) < Math.ceil(rowCount / 8) - 2) {
                    btnsDiv.innerHTML += "<button class=\"btn\">...</button>";
                    btnsDiv.innerHTML += "<button class=\"btn\" data-page=\""+(Math.ceil(rowCount / 8))+"\">"+(Math.ceil(rowCount / 8))+"</button>";
                }
                document.querySelectorAll("[data-page]").forEach(function(btn) {
                    btn.addEventListener("click", function() {
                        addButtons(btn);
                    });
                });
            }
            req.open("GET", "http://localhost/wallency/Vendor/cakephp/cakephp/get-history-rows/"+btn.dataset.page, false);
            req.send(null);
            if (req.status == 200) {
                response = JSON.parse(req.responseText);
                tableBody.innerHTML = "";
                for(var i = 0; i < response.length; i++) {
                    type = response[i]["TransactionHistory"]["type"];
                    tableBody.innerHTML += "<tr><td>"+lang[type]+"</td><td>"+response[i]["TransactionHistory"]["money_on_plus"]+" "+response[i]["TransactionHistory"]["currency_plus"]+"</td><td>"+response[i]["TransactionHistory"]["money_on_minus"]+" "+response[i]["TransactionHistory"]["currency_minus"]+"</td><td>"+response[i]["TransactionHistory"]["transaction_date"]+"</td></tr>";
                }
            }
        }

    });
</script>