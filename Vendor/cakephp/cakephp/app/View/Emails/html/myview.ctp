<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
    </head>
    <body style="font-family: 'Comfortaa';">
        <div class="container" style="width:660px;height:850px;margin:auto;text-align: center;position:relative;">
            <img src="cid:background" alt="" style="position: absolute;top:0;left:0;z-index:1">
            <span style="position: relative; z-index: 2;font-size: 68px;font-weight: bold;margin-top:37px;color: white;display:inline-block;">Wallency</span>
            <span style="position: relative; z-index: 2;display: inline-block; margin-top: 63px;font-size: 30px;color:white;width:500px;height:66px;background-color: rgba(255,255,255,.3);line-height: 66px;box-shadow: 0px 0px 37px -12px rgba(0,0,0,0.75);">Confirm your email address</span><br />
            <span style="position: relative; z-index: 2;display: inline-block;margin-top:80px;background-color:white;width: 400px;padding:40px 50px 10px 50px;line-height:200%;font-size: 18px;height:182px;">Your new Wallency account has been created. Please confirm your email address, so that we know you are the rightful owner of this account.</span><br />
            <a href="http://localhost/wallency/Vendor/cakephp/cakephp/activate?uuid=<?=$uuid?>" style="position: relative; z-index: 2;display: inline-block;background-color:#00669C;width: 480px;padding:10px;font-size: 12px;height:30px;line-height:30px;color:white;font-size:20px;text-decoration:none;cursor:pointer;">Click here to confirm your email address</a><br />
            <img src="cid:icon" alt="" style="position: relative;z-index:2;margin-top:80px;">
            <div style="z-index: 2;position:absolute;bottom:0;width:100%;background-color:rgba(5,23,33,0.8);height:23px;line-height:23px;color:white;">Wallency &copy; <?=date('Y');?></div>
        </div>
    </body>
</html>

