window.addEventListener("DOMContentLoaded", function () {
	var seconds = document.querySelector("#timer");

	setInterval(function () {
		if (parseInt(seconds.innerText) == 1) {
			location.replace("http://localhost/wallency/Vendor/cakephp/cakephp/wallet");
		}
		seconds.innerText = parseInt(seconds.innerText) - 1;
	}, 1000);
});

