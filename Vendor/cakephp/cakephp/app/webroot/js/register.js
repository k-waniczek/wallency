window.addEventListener('DOMContentLoaded', (event) => {

	var loginInput = document.querySelector("input#RegisterUserLogin");
	var nameInput = document.querySelector("input#RegisterUserName");
	var surnameInput = document.querySelector("input#RegisterUserSurname");
	var passwordInput = document.querySelector("input#RegisterUserPassword");
	var repeatPasswordInput = document.querySelector("input#RegisterUserRepeatPassword");
	var birthDateInput = document.querySelector("input#RegisterUserBirthDate");
	var emailInput = document.querySelector("input#RegisterUserEmail");
	
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
    
    loginInput.addEventListener("keyup", function () {
		 validateText(this, "login", this.parentNode);
    });

    nameInput.addEventListener("keyup", function () {
		validateText(this, "name", this.parentNode);
    });

    surnameInput.addEventListener("keyup", function () {
		validateText(this, "surname", this.parentNode);
    });

    passwordInput.addEventListener("keyup", function () {
		validatePassword(this, this.parentNode);
    });

    repeatPasswordInput.addEventListener("keyup", function () {
		checkPasswords(passwordInput, this, this.parentNode);
    });

    birthDateInput.addEventListener("keyup", function () {
		validateBirthDate(this, this.parentNode);
    });

	emailInput.addEventListener("keyup", function () {
		validateEmail(this, this.parentNode);
    });	
		 
	function validateText(input, type, div) {
		if (input.value.length < 3) {
            createWrong(div);
            div.querySelector(".fa-times").setAttribute("title", type.charAt(0).toUpperCase() + type.slice(1) + " must contain at least: 3 characters.");
		} else {
			createCheck(div);
		}
	}

	function validatePassword(input, div) {
		const regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-._]).{8,}$/gm;
		match = regex.exec(input.value);
		if (match) {
			createCheck(div);
		} else {
            createWrong(div);
            div.querySelector(".fa-times").setAttribute("title", "Password must contain at least: 1 big letter, 1 special character and 1 number.");
		}
	}

	function validateBirthDate(input, div) {
	    if (isValidDate(input.value)) {
			createCheck(div);
	    } else {
            createWrong(div);
            div.querySelector(".fa-times").setAttribute("title", "Birthdate must be in this format: YYYY-MM-DD.");
		}
	}

	function checkPasswords(password1, password2, div) {
		if (password2.value == password1.value) {
			createCheck(div);
		} else {
            createWrong(div);
            div.querySelector(".fa-times").setAttribute("title", "Passwords must be the same.");
		}
	}

	function validateEmail(input, div) {
		if (/^[.-_=+\w]+@[a-zA-Z_0-9]+?\.[a-zA-Z]{2,3}$/.test(input.value)) {
			createCheck(div);
		} else {
            createWrong(div);
            div.querySelector(".fa-times").setAttribute("title", "Email must contain at least: 1 @ and 1 dot after domain.");
		}
	}

	function isValidDate(dateString) {
		if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
			return true;
		} else {
			return false;
		}

	}

});
