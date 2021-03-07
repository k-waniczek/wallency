<?php

    echo $this->Html->css("home");
    echo $this->Html->script("home");

    if ($this->Session->read("language") == "eng"){
        $this->Html->script("lang_en", array("inline" => false));
    } else { 
        $this->Html->script("lang_pl", array("inline" => false));
    } 

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div id="mainText">
    <h1><strong>Wallency</strong></h1>
    <span class="mainSiteText col-hd-4 col-fhd-4 col-480p-6 col-360p-6 col-sd-8"><?php echo __("home_text");?></span>
</div>

<svg viewBox="0 0 16 9.6">
    <foreignObject x="0" y="0" width="100%" height="100%">
        <div class="screenshots">
            <div class="nav">
                <div class="circle" data-screenshot="1"></div>
                <div class="circle" data-screenshot="2"></div>
                <div class="circle" data-screenshot="3"></div>
            </div>
            <div class="images">
                <?php
                    echo $this->Html->image("screenshot-wallet-".$this->Session->read("language").".jpg", array("alt" => "Image 1", "class" => "img1 fade", "style" => "opacity: 1"));
                    echo $this->Html->image("screenshot-contact-".$this->Session->read("language").".jpg", array("alt" => "Image 2", "class" => "img2 fade", "style" => "opacity: 0"));
                    echo $this->Html->image("screenshot-exchange-".$this->Session->read("language").".jpg", array("alt" => "Image 3", "class" => "img3 fade", "style" => "opacity: 0"));
                ?>
            </div>
        </div>
    </foreignObject>
</svg>

<div class="chart">
    <canvas id="myChart"></canvas>
</div>


