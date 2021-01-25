window.addEventListener('DOMContentLoaded', (event) => {
	var request = new XMLHttpRequest();

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

	var hamburgerIcon = document.querySelector("i.fa-bars");
	var slideMenu = document.querySelector("div.slideMenu");
	var closeIcon = document.querySelector("span.close");
	var shown = false;

	hamburgerIcon.addEventListener("click", function() {
		if(!shown) {
			slideMenu.style.right = "0";
			shown = true;
		} else {
			slideMenu.style.right = "-70%";
			shown = false;
		}
	});

	closeIcon.addEventListener("click", function() {
		slideMenu.style.right = "-70%";
		shown = false;
	});

	var req = new XMLHttpRequest();

	document.querySelector('select#langSelect').addEventListener('change', function() {
		req.open('GET', 'http://localhost/wallency/Vendor/cakephp/cakephp/change-language/'+this.options[this.selectedIndex].value, false);
        req.send(null);
        if(req.status == 200) {
            window.location.reload();
        }
	});
	
});
