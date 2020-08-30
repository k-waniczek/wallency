window.addEventListener('DOMContentLoaded', (event) => {

	var div = document.querySelector("div.images");
	var images = document.querySelectorAll(".images img");
	var index = 0;

	function disableDefault(evt) {
		evt.preventDefault()
	}

	var request = new XMLHttpRequest();

	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			if (request.status === 200) {
				console.log(request.responseText);
			} else {
				console.log('error');
			}
		}
	}

	request.open('Get', 'createRodoCookie');

	if (document.cookie.substring(document.cookie.length - 1, document.cookie.indexOf('=') + 1)) {
		document.querySelector("div.blur").style.filter = "blur(0px)";
	} else {
		document.body.addEventListener("click", (e) => disableDefault(e));
		document.querySelector("div.blur").style.filter = "blur(2px)";
		document.querySelector("button#accept").addEventListener("click", function () {
			document.querySelector("div.RODOmodal").style.display = "none";
			request.send();
			document.querySelector("div.blur").style.filter = "blur(0px)";
		})

		document.querySelector("button#denie").addEventListener("click", function () {
			window.history.back();
		})
	}

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

	
	var submitBtn = document.querySelector("div.submitRegister > input");
	var inputs = document.querySelectorAll("#RegisterUserRegisterForm input");

	var counter = 0;

	submitBtn.setAttribute("disabled", true);

	inputs.forEach(function(input) {
		input.addEventListener("keyup", function() {
			for(var i = 1; i < inputs.length - 1; i++) {
				if(inputs[i].value.length > 0) {
					counter++;
				}
			}
			
			if(counter >= inputs.length - 2) {
				submitBtn.removeAttribute("disabled");
			} else {
				submitBtn.setAttribute("disabled", true);
			}
			counter = 0;
		})
	})
	
});
