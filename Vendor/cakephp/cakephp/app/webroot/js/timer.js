window.addEventListener("DOMContentLoaded", function () {
	var seconds = document.querySelector("#timer");

	setInterval(function () {
		if (parseInt(seconds.innerText) == 1) {
			var link = (document.querySelector("input#link")) ? document.querySelector("input#link").value : "http://localhost/wallency/Vendor/cakephp/cakephp/wallet";
			location.replace(link);
		}
		seconds.innerText = parseInt(seconds.innerText) - 1;
	}, 1000);
});

