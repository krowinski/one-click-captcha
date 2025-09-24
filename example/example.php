<?php

declare(strict_types=1);

use OneClickCaptcha\Service\OneClickCaptchaFactory;

include __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', '1');
error_reporting(E_ALL);

$oneClickCaptcha = OneClickCaptchaFactory::getOneClickCaptcha();

// simple demonstration!
$request = $_GET['get_captcha'] ?? '';
if ($request === 'true') {
    try {
        $oneClickCaptcha->renderCaptcha();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} elseif (isset($_REQUEST['position'][0], $_REQUEST['position'][1])) {
    if ($oneClickCaptcha->validate((int)$_REQUEST['position'][0], (int)$_REQUEST['position'][1])) {
        echo '<h3>You are human 👤!!</h3>';
    } else {
        echo '<h3>You are robot 🤖 !!</h3>';
    }
}

// this is all html you need to validate captcha
echo '
<form action="example.php" method="POST">
	<input type="image" src="example.php?get_captcha=true" name="position[]" alt="problem with image"/>
</form>
';
