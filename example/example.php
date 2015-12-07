<?php
include __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$OneClickCaptchaServiceFactory = new \OneClickCaptcha\Service\OneClickCaptchaServiceFactory();
$oneClickCaptcha = $OneClickCaptchaServiceFactory->getOneClickCaptcha();

// simple demonstration!
$request = isset($_GET['get_captcha']) ? $_GET['get_captcha'] : '';
if ($request === 'true') {
    $oneClickCaptcha->showCaptcha();
} else {
    if (isset($_REQUEST['position'][0], $_REQUEST['position'][1])) {
        if (true === $oneClickCaptcha->validate($_REQUEST['position'][0], $_REQUEST['position'][1])) {

            echo '<h3>You are human!!</h3>';
        } else {
            echo '<h3>Wrong!</h3>';
        }
    }
}

// this is all html you need to validate captcha
echo '
<form action="example.php" method="POST">
	<input type="image" src="example.php?get_captcha=true" name="position[]"/>
</form>
';