window.addEventListener("DOMContentLoaded", function () {
    var divs = document.querySelectorAll("[data-offer]");

    divs.forEach(function(div) {
        div.addEventListener("click", function() {
            if (this.dataset.hidden == "false") {
                if(window.innerWidth > 1140) {
                    this.style.height = "300px";
                } else if (window.innerWidth < 800) {
                    if(this.children[0].children[2].clientHeight > this.children[0].clientHeight) {
                        this.style.height = this.children[0].children[2].clientHeight + this.children[1].children[0].clientHeight + "px";
                    } else {
                        this.style.height = this.children[0].clientHeight + this.children[1].children[0].clientHeight + "px";
                    }
                } else {
                    this.style.height = "350px";
                }
                this.dataset.hidden = "true";
            } else {
                this.style.height = "200px";
                this.dataset.hidden = "false";
            }
        });
    })
});