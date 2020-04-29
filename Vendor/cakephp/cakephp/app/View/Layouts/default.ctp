<!DOCTYPE html>
<html>
<head>
	<?php
		echo $this->Html->script("main.js");
		echo $this->Html->script("https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js");
		echo $this->Html->script("https://cdn.jsdelivr.net/npm/sweetalert2@9");

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">
		
	</div>
</body>
</html>
