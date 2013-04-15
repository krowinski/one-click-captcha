<?php
# Sample of usage OneClickCaptcha
include('oneClickCaptcha.php');


$oneClickCaptcha = new oneClickCaptcha();

// simple demonstration!
$request = isset($_GET['get_captcha']) ? $_GET['get_captcha'] : '';
if ($request === 'true')
{
	$oneClickCaptcha->GenerateCaptchaImg();
}
else if (true == $oneClickCaptcha->Validate())
{
	echo '<h3>You are human!!</h3>';
}
else
{
	echo '<h3>Wrong!</h3>';
}

// this is all html you need to validate captcha
echo '
<form action="example.php" method="POST">
	<input type="image" src="example.php?get_captcha=true" name="position[]"/>
</form>
';