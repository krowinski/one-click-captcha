[![Build Status](https://travis-ci.org/krowinski/one-click-captcha.svg?branch=1.2)](https://travis-ci.org/krowinski/one-click-captcha)

This lib can perform CAPTCHA validation based on user clicks on circles.

It render an image with several circles on random positions. Only one circle appears cut.

The class performs CAPTCHA validation by checking the position where the user clicks on the image to verify it it is inside of the circle that is cut.

The generated image is served in PNG format. The values of the rendered circles are stored in session variables for subsequent validation.

The size and colors of the image and the circles are configurable parameters.

###### 1. install using composer ######
```bash
composer require krowinski/one-click-captcha
```
###### 2. example ######

```php

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

```

