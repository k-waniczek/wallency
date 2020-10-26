<!DOCTYPE html>
<html>
<head>
	<?php
		echo $this->Html->script('main');
		echo $this->Html->css('grid');
		echo $this->Html->css('layout');
		echo $this->Html->script('https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js');
		echo $this->Html->script('https://cdn.jsdelivr.net/npm/sweetalert2@9');
		echo "<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.14.0/css/all.css' integrity='sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc' crossorigin='anonymous'>";
		echo $this->Html->script("glider");
		echo $this->Html->css("glider");

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="blur">
		<div class="slideMenu">
			<span class="close">x</span>
			<ul>
				<li><a href="profile">Profile</a></li>
				<li><a href="wallet">Wallet</a></li>
				<li><a href="deposit">Deposit</a></li>
				<li><a href="withdraw">Withdraw</a></li>
				<li><a href="exchange-form">Exchange</a></li>
				<li><a href="transfer-form">Transfer</a></li>
				<li class="hamburgerMenu"><i class="fas fa-bars"></i></li>
			</ul>
		</div>
		<nav>
			<span class="logo col-fhd-2 col-hd-2 col-fhd-2 col-hd-2 col-480p-2 col-360p-2 col-sd-1"><a href="home">LOGO</a></span>
			<div class="menu col-fhd-6 col-hd-6 col-480p-6 col-360p-6 col-sd-9">
				<ul>
					<li><a href="profile">Profile</a></li>
					<li><a href="wallet">Wallet</a></li>
					<li><a href="deposit">Deposit</a></li>
					<li><a href="withdraw">Withdraw</a></li>
					<li><a href="exchange-form">Exchange</a></li>
					<li><a href="transfer-form">Transfer</a></li>
					<li class="hamburgerMenu"><i class="fas fa-bars"></i></li>
				</ul>
			</div>
			<span class="registerAndLogin col-fhd-2 col-hd-2 col-480p-2 col-360p-2">
				<span class="register"><a href="logout">Logout</a></span> 
			</span>
		</nav>
		<div class="container">
			<?php echo $this->fetch('content');?>
		</div>
		<div class="footer">
			<div class="text col-fhd-8 col-hd-8 col-480p-8 col-360p-8 col-sd-8">
				<div class="menu">
					<ul>
						<li>Home</li>
						<li>About</li>
						<li>Contact</li>
						<li>Career</li>
					</ul>
				</div><br />
				<span class="logo col-fhd-2 col-hd-2 col-480p-2 col-360p-2 col-sd-2">WALLENCY</span>
				<span>Copyright &copy; <?= date('Y')?> Wallency.
				Wallency was created by Kamil Waniczek.</span>
				<span class="privacy-policy">
					<a href="privacy-policy" target="_blank">Privacy Policy</a>
					<a href="terms-of-service">Terms of Service</a>
				</span>
			</div>	
		</div>
	</div>
	<?php
		if(!isset($_COOKIE['CakeCookie']['rodo_accepted'])) {
			echo $this->element('rodo-modal');
		}
	?>
</body>
</html>

