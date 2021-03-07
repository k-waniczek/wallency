window.addEventListener("DOMContentLoaded", (event) => {
    var rowCount = parseInt(document.querySelector("#rowCount").value);
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

    document.querySelectorAll("[data-page")[0].style.background = "#276b9c";

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
        currentPage = btn.dataset.page;
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
        document.querySelectorAll("[data-page").forEach(function (element) {
            if(element.dataset.page == currentPage) {
                element.style.background = "#276b9c";
            }
        })
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