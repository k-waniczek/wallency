window.addEventListener("DOMContentLoaded", function () {
    var divs = document.querySelectorAll("[data-offer]");

    divs.forEach(function(div) {
        div.addEventListener("click", function() {
            if (this.dataset.hidden == "false") {
                this.style.height = "300px";
                this.dataset.hidden = "true";
            } else {
                this.style.height = "200px";
                this.dataset.hidden = "false";
            }
        });
    })
});