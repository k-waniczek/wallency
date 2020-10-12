window.addEventListener('DOMContentLoaded', (event) => {

	// var submitBtn = document.querySelector("div.submitRegister > input");
	// var inputs = document.querySelectorAll("#RegisterUserRegisterForm input");

	// var counter = 0;

	// submitBtn.setAttribute("disabled", true);

	// inputs.forEach(function(input) {
	// 	input.addEventListener("keyup", function() {
	// 		for(var i = 1; i < inputs.length - 1; i++) {
	// 			if(inputs[i].value.length > 0) {
	// 				counter++;
	// 			}
	// 		}
			
	// 		if(counter >= inputs.length - 2) {
	// 			submitBtn.removeAttribute("disabled");
	// 		} else {
	// 			submitBtn.setAttribute("disabled", true);
	// 		}
	// 		counter = 0;
	// 	});
	// });

	// function disableDefault(evt) {
	// 	evt.preventDefault()
	// }

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
	function noScroll() {
		window.scrollTo(0, 0);
	}
	  
	if (document.cookie.substring(document.cookie.length - 1, document.cookie.indexOf('=') + 1)) {
		document.querySelector("div.blur").style.filter = "blur(0px)";
	} else {
		window.addEventListener('scroll', noScroll);
		document.querySelector("div.blur").style.backgroundColor = "rgba(255, 255, 255, 0.5)";
		document.querySelector("div.blur").style.filter = "blur(3px)";
		document.querySelector("button#accept").addEventListener("click", function () {
			window.removeEventListener('scroll', noScroll);
			document.querySelector("div.rodoModal").style.display = "none";
			request.send();
			document.querySelector("div.blur").style.backgroundColor = "transparent";
			document.querySelector("div.blur").style.filter = "blur(0px)";
		});

		document.querySelector("button#denie").addEventListener("click", function () {
			window.history.back();
		});
	}

	new Glider(document.querySelector('.glider'), {
		slidesToShow: 1,
		dots: '#dots',
		arrows: {
			prev: '.glider-prev',
			next: '.glider-next'
		}
	})
	
});
