<table background="cid:background" style="margin: 0;border-spacing: 0px; position: absolute; transform: translate(-50%, -50%); top: 50%; left:50%;height: 850px; width:600px;">
    <tr style="background-color: #051721;height:75px; color: white;">
        <td style="padding:13px;"><img src="cid:logo" alt="logo" style="width: 80px;vertical-align: middle;margin-top: -10px;"/></td>
        <td style="padding:13px;">
            <ul style="list-style: none;margin: 0;padding: 0;display: inline-block; float: right;">
                <li style="float: left;line-height: 75px;margin: 0 10px 0 10px;font-size: 16px;"><a style="text-decoration:none;color:white;" href="localhost/wallency/Vendor/cakephp/cakephp/home"><?php echo __("home");?></a></li>
                <li style="float: left;line-height: 75px;margin: 0 10px 0 10px;font-size: 16px;"><a style="text-decoration:none;color:white;" href="localhost/wallency/Vendor/cakephp/cakephp/about"><?php echo __("about");?></a></li>
                <li style="float: left;line-height: 75px;margin: 0 10px 0 10px;font-size: 16px;"><a style="text-decoration:none;color:white;" href="localhost/wallency/Vendor/cakephp/cakephp/faq">FAQ</a></li>
            </ul>
        </td>
    </tr>
    <tr style="color: white;text-align: center;">
        <td style="padding:13px;" colspan="2"><?=strtoupper($currency);?> <?php echo __("changed_by");?> <?=$percent?>%</td>
    </tr>
    <tr style="background-color: #276b9c; height: 50px;">
        <td style="padding:13px;" colspan="2"><?php echo __("copyright");?> © <?=date("Y");?> Wallency. Wallency <?php echo __("copyright_rest");?>.</td>
    </tr>
</table>


