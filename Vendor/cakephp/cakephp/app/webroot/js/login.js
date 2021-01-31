window.addEventListener('DOMContentLoaded', function () {
    var eye = document.querySelector(".fa-eye");
    var shown = false;
    eye.addEventListener('click', function() {
        if (!shown) {
            document.querySelector("input#LoginUserPassword").setAttribute('type', 'text');
            shown = true;
        } else {
            document.querySelector("input#LoginUserPassword").setAttribute('type', 'password');
            shown = false;
        }
    });
});