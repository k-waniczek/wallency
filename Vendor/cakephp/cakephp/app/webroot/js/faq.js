window.addEventListener('DOMContentLoaded', function () {
    var arrows = document.querySelectorAll('[data-question]');
	arrows.forEach(function (arrow) {
		arrow.addEventListener('click', function () {
            if(document.querySelector("#answer"+arrow.dataset.question).dataset.shown == "false") {
                document.querySelector("#answer"+arrow.dataset.question).dataset.shown = "true";
                document.querySelector("#answer"+arrow.dataset.question).style.transform = "scaleY(1)";
            } else {
                document.querySelector("#answer"+arrow.dataset.question).dataset.shown = "false";
                document.querySelector("#answer"+arrow.dataset.question).style.transform = "scaleY(0)";
            }
		});
	});
});
