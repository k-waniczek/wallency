window.addEventListener("DOMContentLoaded", (event) => {
	var images = document.querySelectorAll(".images img");
	var circles = document.querySelectorAll(".circle");
	var index = 0;

	circles.forEach(circle => {
		circle.addEventListener("click", function () {
			goToSlide(this.dataset.screenshot - 1);
		});
	})

	function goToSlide(n) {
		for(var i = 0; i < images.length; i++) {
			if(images[i] != images[n]) {
				images[i].style.display = "none";
				images[i].style.opacity = "0";
			}
		}
		images[n].style.display = "block";
		images[n].style.opacity = "1";
	}

	setInterval(function () {
		if (index > images.length - 1) {
			index = 0;
		}
		goToSlide(index);
		index++;
    }, 8000);

	var index = 1;
	var data = [];
	var labels = [];
	var ctx = document.getElementById("myChart").getContext("2d");
	var curDate;
	var histData;
	
	function pad(value) {
		if (value < 10) {
			return "0" + value;
		} else {
			return value;
		}
	}

	var req = new XMLHttpRequest();
	req.open("GET", "https://min-api.cryptocompare.com/data/v2/histominute?fsym=BTC&tsym=USD&limit=19&aggregate=15&api_key=b76f05d7ae85a73e7992e1044fb1c4b3f07171bfe67a8e21026072f0ac0a26d9", false);
	req.send(null);
	if (req.status == 200) {
		histData = JSON.parse(req.responseText).Data.Data;
		for(var i = 0; i < histData.length; i++) {
			curDate = new Date(histData[i].time * 1000);
			labels[i] = curDate.getUTCFullYear()+"-"+pad(curDate.getUTCMonth()+1)+"-"+pad(curDate.getUTCDate()) + " " + pad(curDate.getHours()) + ":" + pad(curDate.getMinutes());
			data[i] = histData[i].high;
		}
	}

	setInterval(function() {
		if (new Date().getMinutes() == 0 || new Date().getMinutes() == 15 || new Date().getMinutes() == 30 || new Date().getMinutes() == 45) {
			req.open("GET", "https://min-api.cryptocompare.com/data/v2/histominute?fsym=BTC&tsym=USD&limit=19&aggregate=15&api_key=b76f05d7ae85a73e7992e1044fb1c4b3f07171bfe67a8e21026072f0ac0a26d9", false);
			req.send(null);
			if (req.status == 200) {   
				histData = JSON.parse(req.responseText).Data.Data;
				for(var i = 0; i < histData.length; i++) {
					curDate = new Date(histData[i].time * 1000);
					labels[i] = pad(curDate.getHours()) + ":" + pad(curDate.getMinutes());
					data[i] = histData[i].high;
				}           
				if (data.length > 20) {
					data.shift();
					labels.shift();
				}
				if (data[19] >= data[18]) {
					myChart.data.datasets.forEach(function (dataset) {
						dataset.borderColor = "#00ff00";
					});
				} else if (data[19] < data[18]) {
					myChart.data.datasets.forEach(function (dataset) {
						dataset.borderColor = "#ff0000";
					});
				}
				myChart.update();
			}
		}
	}, 1000 * 60);

	var myChart = new Chart(ctx, {
		"type": "line",
		"data": {
			"labels": labels,
			"datasets": [{
				"label": lang.btc_value,
				"data": data,
				"fill": false,
				"borderColor": (data[data.length-1] >= data[data.length-2]) ? "#00ff00" : "#ff0000",
				"lineTension": 0
			}]
		},
		"options": {
			"responsive": true,
			"scales": {
				"xAxes": [{
					gridLines: {
						display: false
					},
				}],
				"yAxes": [{
					gridLines: {
						color: "#666666"
					},
				}]
			}
		}
	});
});