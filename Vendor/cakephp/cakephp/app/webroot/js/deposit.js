window.addEventListener("DOMContentLoaded", function () {
	var amountInput = document.querySelector("#DepositAmount");

	amountInput.value = "";

	if (amountInput.value < 0 || amountInput.value == "") {
		document.querySelector("div.submit input").setAttribute("disabled", true);
	}


	amountInput.addEventListener("keyup", function () {
		this.value = this.value.replace(/[^0-9.]/g, "");
		if (amountInput.value > 500) {
			amountInput.value = 500;
		}
		if (amountInput.value < 0 || amountInput.value == "" || amountInput.value > 500) {
			document.querySelector("div.submit input").setAttribute("disabled", true);
		} else {
			document.querySelector("div.submit input").removeAttribute("disabled");
		}
	});
});