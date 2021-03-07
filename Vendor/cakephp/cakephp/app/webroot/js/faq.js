window.addEventListener("DOMContentLoaded", function () {
    var arrows = document.querySelectorAll("[data-question]");
	arrows.forEach(function (arrow) {
		arrow.addEventListener("click", function () {
            if (document.querySelector("#answer"+arrow.dataset.question).dataset.shown == "false") {
                document.querySelector("#answer"+arrow.dataset.question).dataset.shown = "true";
                document.querySelector("#answer"+arrow.dataset.question).parentNode.style.height = this.children[1].clientHeight + 50 + "px";
                setTimeout(function() {
                    document.querySelector("#answer"+arrow.dataset.question).style.transform = "scaleY(1)";
                }, 200);
            } else {
                document.querySelector("#answer"+arrow.dataset.question).dataset.shown = "false";
                document.querySelector("#answer"+arrow.dataset.question).parentNode.style.height = "50px";
                document.querySelector("#answer"+arrow.dataset.question).style.transform = "scaleY(0)";       
            }
		});
	});
});
