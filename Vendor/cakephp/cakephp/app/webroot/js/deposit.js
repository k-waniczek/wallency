window.addEventListener("DOMContentLoaded", function () {
	var amountInput = document.querySelector("#DepositAmount");

	amountInput.value = "";
	document.querySelector("div.submit input").setAttribute("disabled", true);

	amountInput.setAttribute("maxlength", 3);

	amountInput.addEventListener("keyup", function () {
		if (this.value.match(/^[1-9][0-9]{0,}$|^[1-9][0-9]{0,}(\.[0-9]{1,2})$/gm) == null || parseFloat(amountInput.value) < 0 || amountInput.value == "" || parseFloat(amountInput.value) > 500) {
            document.querySelector("div.submit input").setAttribute("disabled", true);
        } else {
            document.querySelector("div.submit input").removeAttribute("disabled");
        }
        if (parseFloat(amountInput.value) > 500) {
            amountInput.value = 500;
            document.querySelector("div.submit input").removeAttribute("disabled");
        }
	});
});