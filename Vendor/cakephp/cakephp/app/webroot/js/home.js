window.addEventListener('DOMContentLoaded', (event) => {
    var div = document.querySelector("div.images");
	var images = document.querySelectorAll(".images img");
	var index = 0;

	function goToSlide(n) {
		if (n == 0) {
			images[images.length - 1].style.display = "none";
			images[images.length - 1].style.opacity = "0";
		} else {
			images[n - 1].style.display = "none";
			images[n - 1].style.opacity = "0";
		}
		images[n].style.display = "block";
		images[n].style.opacity = "1";
	}

	setInterval(function () {
		if (index > images.length - 1) {
			index = 0;
		}
		images[index].style.display = "none";
		images[index].style.opacity = "0";
		if (index == images.length - 1) {
			images[0].style.display = "block";
			images[0].style.opacity = "1";
		} else {
			images[index + 1].style.display = "block";
			images[index + 1].style.opacity = "1";
		}
		index++;
    }, 8000);
    
});