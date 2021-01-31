<?php

    echo $this->Html->css('rules');
    echo $this->Html->css('full_page_container_height');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>

<div class="rules">
    <ol>
        <li>Your login cannot contain any swear word. If an administrator will notice that your account has one, your account may be temporarily blocked, or terminated.</li>
        <li>If you find any exploit in the website, please contact owner by the contact page.</li>
        <li>On this website money you deposit and withdraw from your account, is not real money, this website is only for educational purposes.</li>
        <li>In order to use our website you need to create an account, with the registration you have to accept terms and conditions.</li>
        <li>Any activities that are not expressly permitted by the Regulations, in particular are prohibited:
            <ul>
                <li>activities which can destibilize website functionality,</li>
                <li>usage of viruses, bots, bugs, or other computer scripts, files or programs (in particular, automating script and application processes or other codes, files or tools),</li>
                <li>use of any content posted on the site in a manner other than only for personal personal use</li>
            </ul>
        </li>
    </ol>
</div>
