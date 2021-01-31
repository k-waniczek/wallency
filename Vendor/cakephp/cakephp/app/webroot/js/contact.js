window.addEventListener('DOMContentLoaded', function () {
    var msgLen = document.querySelector('span.messageLength');
    var textArea = document.querySelector('textarea');

    checkMessageLength();

    textArea.addEventListener('keyup', function () {
        checkMessageLength();
    });

    function checkMessageLength () {
        msgLen.textContent = textArea.value.length + "/200";
        if (textArea.value.length > 170 && textArea.value.length < 200) {
            applyAnimation('yellow');
        } else if (textArea.value.length == 200) {
            applyAnimation('red');
        } else {
            msgLen.style.color = 'rgb(0, 211, 0)';
            msgLen.style.animation = '';
            document.querySelector('div.submit input').removeAttribute('disabled');
        }
    }

    function applyAnimation (color) {
        msgLen.style.color = color;
        msgLen.style.animation = 'shake 0.25s';
        setTimeout(function() {
            msgLen.style.animation = '';
        }, 250);
    }

});