window.addEventListener("DOMContentLoaded", (event) => {

	var loginInput = document.querySelector("input#RegisterUserLogin");
	var nameInput = document.querySelector("input#RegisterUserName");
	var surnameInput = document.querySelector("input#RegisterUserSurname");
	var passwordInput = document.querySelector("input#RegisterUserPassword");
	var repeatPasswordInput = document.querySelector("input#RegisterUserRepeatPassword");
	var birthDateInput = document.querySelector("input#RegisterUserBirthDate");
	var emailInput = document.querySelector("input#RegisterUserEmail");
	var submitInput = document.querySelector("div.submit input");

	var inputsValidated = {loginInput: "", nameInput: "", surnameInput: "", emailInput: "", passwordInput: "", repeatPasswordInput: "", birthdateInput: ""};
	
	function createCheck(div) {
		var check = document.createElement("i");
		check.setAttribute("class", "fas fa-check");
		if (!div.querySelector(".fa-check")) {
			div.append(check);
		}
		if (div.querySelector(".fa-times")) {
			div.removeChild(div.querySelector(".fa-times"));
        }
	}

	function createWrong(div) {
		var wrong = document.createElement("i");
		wrong.setAttribute("class", "fas fa-times");
		if (!div.querySelector(".fa-times")) {
			div.append(wrong);
		}
		if (div.querySelector(".fa-check")) {
			div.removeChild(div.querySelector(".fa-check"));
        }
	}

	inputsValidated.loginInput = validateText(loginInput, "login", loginInput.parentNode), false;
	inputsValidated.nameInput = validateText(nameInput, "name", nameInput.parentNode, false);
	inputsValidated.surnameInput = validateText(surnameInput, "surname", surnameInput.parentNode, false);
	inputsValidated.passwordInput = validatePassword(passwordInput, passwordInput.parentNode, false);
	inputsValidated.repeatPasswordInput = checkPasswords(passwordInput, repeatPasswordInput, repeatPasswordInput.parentNode, false);
	inputsValidated.birthdateInput = validateBirthDate(birthDateInput, birthDateInput.parentNode, false);
	inputsValidated.emailInput = validateEmail(emailInput, emailInput.parentNode, false);
	checkIfAbleToSubmit();

    loginInput.addEventListener("keyup", function () {
		inputsValidated.loginInput = validateText(this, "login", this.parentNode, true);
		checkIfAbleToSubmit();
    });

    nameInput.addEventListener("keyup", function () {
		inputsValidated.nameInput = validateText(this, "name", this.parentNode, true);
		checkIfAbleToSubmit();
    });

    surnameInput.addEventListener("keyup", function () {
		inputsValidated.surnameInput = validateText(this, "surname", this.parentNode, true);
		checkIfAbleToSubmit();
    });

    passwordInput.addEventListener("keyup", function () {
		inputsValidated.passwordInput = validatePassword(this, this.parentNode, true);
		inputsValidated.repeatPasswordInput = checkPasswords(repeatPasswordInput, this, this.parentNode, false);
		checkIfAbleToSubmit();
    });

    repeatPasswordInput.addEventListener("keyup", function () {
		inputsValidated.repeatPasswordInput = checkPasswords(passwordInput, this, this.parentNode, true);
		checkIfAbleToSubmit();
    });

    birthDateInput.addEventListener("keyup", function () {
		inputsValidated.birthdateInput = validateBirthDate(this, this.parentNode, true);
		checkIfAbleToSubmit();
    });

	emailInput.addEventListener("keyup", function () {
		inputsValidated.emailInput = validateEmail(this, this.parentNode, true);
		checkIfAbleToSubmit();
    });	

	document.querySelector("#RegisterUserIsAdult").addEventListener("change", function() {
		checkIfAbleToSubmit();
	});
		 
	function validateText(input, type, div, createElement) {
		if (input.value.length < 3) {
			if(createElement) {
            	createWrong(div);
            	div.querySelector(".fa-times").setAttribute("title", type.charAt(0).toUpperCase() + type.slice(1) + " must contain at least: 3 characters.");
			}
			return false;
		} else {
			if (createElement) {
				createCheck(div);
			}
			return true;
		}
	}

	function validatePassword(input, div, createElement) {
		const regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-._]).{8,}$/gm;
		match = regex.exec(input.value);
		if (match) {
			if (createElement) {
				createCheck(div);
			}
			return true;
		} else {
			if(createElement) {
				createWrong(div);
				div.querySelector(".fa-times").setAttribute("title", "New password must contain at least: 1 big letter, 1 special character, 1 number and needs to be at least 8 characters long.");
			}
			return false;
		}
	}

	function validateBirthDate(input, div, createElement) {
	    if (isValidDate(input.value)) {
			if (createElement) {
				createCheck(div);
			}
			return true;
	    } else {
			if(createElement) {
				createWrong(div);
				div.querySelector(".fa-times").setAttribute("title", "Birthdate must be in this format: YYYY-MM-DD.");
			}
			return false;
		}
	}

	function checkPasswords(password1, password2, div, createElement) {
		if (password2.value == password1.value) {
			if (createElement) {
				createCheck(div);
			}
			return true;
		} else {
			if(createElement) {
				createWrong(div);
				div.querySelector(".fa-times").setAttribute("title", "Passwords must be the same.");
			}
			return false;
		}
	}

	function validateEmail(input, div, createElement) {
		if (/^[.-_=+\w]+@[a-zA-Z_0-9]+?\.[a-zA-Z]{2,3}$/.test(input.value)) {
			if (createElement) {
				createCheck(div);
			}
			return true;
		} else {
			if(createElement) {
				createWrong(div);
				div.querySelector(".fa-times").setAttribute("title", "Email must contain at least: 1 @ and 1 dot after domain.");
			}
			return false;
		}
	}

	function isValidDate(dateString) {
		if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
			return true;
		} else {
			return false;
		}
	}

	function checkIfAbleToSubmit() {
		console.log(inputsValidated);
		var count = 0;
		for (var input in inputsValidated) {
			if(inputsValidated[input]) {
				count++;
			}	
		}
		if (document.querySelectorAll(".fa-times").length > 0 || document.querySelector("#RegisterUserIsAdult").checked == false || count != 7) {
			submitInput.setAttribute("disabled", true);			
		} else {
			submitInput.removeAttribute("disabled");
			console.log("input enabled");
		}
	}
});
