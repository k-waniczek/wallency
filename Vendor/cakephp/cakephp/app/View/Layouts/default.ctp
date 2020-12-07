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
				<li><a href="home">Home</a></li>
				<li><a href="about">About</a></li>
				<li><a href="contact">Contact</a></li>
				<li><a href="career">Career</a></li>
				<li><a href="register">Register</a></li>
				<li><a href="login">Login</a></li>
			</ul>
		</div>
		<nav>
			<span class="logo col-fhd-2 col-hd-2 col-fhd-2 col-hd-2 col-480p-2 col-360p-2 col-sd-1"><a href="home"><?php echo $this->Html->image('wallet.png', array('alt' => 'Logo', 'class' => 'logoImg'));?></a></span>
			<div class="menu col-fhd-6 col-hd-6 col-480p-6 col-360p-6 col-sd-9">
				<ul>
					<li><a href="home"><?php echo __('home');?></a></li>
					<li><a href="about"><?php echo __('about');?></a></li>
					<li><a href="contact"><?php echo __('contact');?></a></li>
					<li><a href="career"><?php echo __('career');?></a></li>
					<li class="hamburgerMenu"><i class="fas fa-bars"></i></li>
					<select id="langSelect">
						<option value="eng">eng</option>
						<option value="pol">pol</option>
					</select>
				</ul>
			</div>
			<span class="registerAndLogin col-fhd-2 col-hd-2 col-480p-2 col-360p-2">
				<span class="register"><a href="register"><?php echo __('register');?></a></span> 
				| 
				<span class="login"><a href="login"><?php echo __('login');?></a></span>
			</span>
		</nav>
		<div class="container">
			<?php echo $this->fetch('content');?>
		</div>
		<div class="footer">
			<div class="text col-fhd-8 col-hd-8 col-480p-8 col-360p-8 col-sd-8">
				<div class="menu">
					<ul>
						<li><?php echo __('home');?></li>
						<li><?php echo __('about');?></li>
						<li><?php echo __('contact');?></li>
						<li><?php echo __('career');?></li>
					</ul>
				</div><br />
				<span class="logo col-fhd-2 col-hd-2 col-480p-2 col-360p-2 col-sd-2">WALLENCY</span>
				<span><?php echo __('copyright');?> &copy; <?= date('Y')?> Wallency.
				Wallency <?php echo __('copyright_rest');?>.</span>
				<span class="privacy-policy">
					<a href="privacy-policy" target="_blank"><?php echo __('privacy_policy');?></a>
					<a href="terms-of-service"><?php echo __('terms_of_service');?></a>
				</span><br/><br/>
				<div>Icons made by <a href="http://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
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
