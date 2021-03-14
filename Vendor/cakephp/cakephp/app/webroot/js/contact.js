window.addEventListener("DOMContentLoaded", function () {
    var msgLen = document.querySelector("span.messageLength");
    var textArea = document.querySelector("textarea");
    var inputs = document.querySelectorAll("input[type=text]");
    var inputSubmit = document.querySelector("div.submit input");

    checkMessageLength();
    inputs.forEach(input => {
        checkInput(input);
        input.addEventListener("keyup", function() {
            checkInput(this);
        });
    });

    function checkInput(input) {
        if(input.value.length == 0) {
            inputSubmit.setAttribute("disabled", true);
            inputSubmit.style.cursor = "default";
        }
    }

    textArea.addEventListener("keyup", function () {
        checkMessageLength();
    });

    function checkMessageLength () {
        msgLen.textContent = textArea.value.length + "/200";
        if (textArea.value.length > 170 && textArea.value.length < 200) {
            applyAnimation("yellow");
        } else if (textArea.value.length == 200) {
            applyAnimation("red");
        } else {
            msgLen.style.color = "#00d300";
            msgLen.style.animation = "";
            inputSubmit.removeAttribute("disabled");
        }
    }

    function applyAnimation (color) {
        msgLen.style.color = color;
        msgLen.style.animation = "shake 0.25s";
        setTimeout(function() {
            msgLen.style.animation = "";
        }, 250);
    }

});