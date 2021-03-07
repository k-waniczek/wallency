<?php

    echo $this->Html->css("rules");
    echo $this->Html->css("full_page_container_height");

    echo $this->fetch("meta");
    echo $this->fetch("css");
    echo $this->fetch("script");

?>

<div class="rules col-8k-6 col-4k-6 col-wqhd-6 col-fhd-6 col-hd-8 col-480p-8 col-360p-9 col-sd-10">
    <ol>
        <li class="rule"><?php echo __("rule1");?></li>
        <li class="rule"><?php echo __("rule2");?></li>
        <li class="rule"><?php echo __("rule3");?></li>
        <li class="rule"><?php echo __("rule4");?></li>
        <li class="rule"><?php echo __("rule5");?>
            <ul>
                <li class="subrule"><?php echo __("rule5sub1");?></li>
                <li class="subrule"><?php echo __("rule5sub2");?></li>
                <li class="subrule"><?php echo __("rule5sub3");?></li>
            </ul>
        </li>
    </ol>
</div>
