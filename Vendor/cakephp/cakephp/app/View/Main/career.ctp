<?php

    echo $this->Html->css("career");
    echo $this->Html->script("career");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>
<div class="offer" data-offer="1" data-hidden="false">
	<div class="main">
		<div class="logoImgCareerDiv">
			<?php echo $this->Html->image("wallet.png", array("alt" => "Logo", "class" => "careerLogoImg"));?>
		</div>
		<div class="info">
			<span class="jobTitle">Middle Backend Developer</span>
			<span class="sallary">7000 - 12000 PLN brutto</span>
			<span class="place">Katowice</span>
		</div>
		<div class="tech">
			<span class="technologies">PHP</span>
			<span class="technologies">Node.js</span>
			<span class="technologies">Postgre SQL</span>
			<span class="technologies">Docker</span>
		</div>
		
	</div>
	<div class="description">
		<span>
			<?php echo __("career_description_1");?>
		</span>
	</div>
</div>
<div class="offer" data-offer="2" data-hidden="false">
	<div class="main">
		<div class="logoImgCareerDiv">
			<?php echo $this->Html->image("wallet.png", array("alt" => "Logo", "class" => "careerLogoImg"));?>
		</div>
		<div class="info">
			<span class="jobTitle">Junior Python Developer</span>
			<span class="sallary">5000 - 8000 netto + VAT</span>
			<span class="place">Warszawa</span>
		</div>
		<div class="tech">
			<span class="technologies">Python</span>
			<span class="technologies">MySQL</span>
			<span class="technologies">OpenCV</span>
			<span class="technologies">Rabbit</span>
			<span class="technologies">NumPy</span>
		</div>
		
	</div>
	<div class="description">
		<span>
			<?php echo __("career_description_2");?>
		</span>
	</div>
</div>
<div class="offer" data-offer="3" data-hidden="false">
	<div class="main">
		<div class="logoImgCareerDiv">
			<?php echo $this->Html->image("wallet.png", array("alt" => "Logo", "class" => "careerLogoImg"));?>
		</div>
		<div class="info">
			<span class="jobTitle">Senior Fullstack Developer</span>
			<span class="sallary">20000 - 30000 PLN brutto</span>
			<span class="place">Gdańsk</span>
		</div>
		<div class="tech">
			<span class="technologies">PHP</span>
			<span class="technologies">MySQL</span>
			<span class="technologies">Wordpress</span>
			<span class="technologies">JavaScript</span>
			<span class="technologies">Drupal</span>
			<span class="technologies">SASS</span>
			<span class="technologies">React</span>
			<span class="technologies">Angular</span>
			<span class="technologies">Vue</span>
			<span class="technologies">Docker</span>
		</div>
		
	</div>
	<div class="description">
		<span>
			<?php echo __("career_description_3");?>
		</span>
	</div>
</div>
