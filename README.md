# OneClick captcha 

[![Latest Stable Version](https://poser.pugx.org/krowinski/one-click-captcha/v/stable)](https://packagist.org/packages/krowinski/one-click-captcha) [![Total Downloads](https://poser.pugx.org/krowinski/one-click-captcha/downloads)](https://packagist.org/packages/krowinski/one-click-captcha) [![Latest Unstable Version](https://poser.pugx.org/krowinski/one-click-captcha/v/unstable)](https://packagist.org/packages/krowinski/one-click-captcha) [![License](https://poser.pugx.org/krowinski/one-click-captcha/license)](https://packagist.org/packages/krowinski/one-click-captcha)

This lib can perform CAPTCHA validation based on user clicks on circles.

It renders an image with several circles on random positions. Only one circle appears cut.

The class performs CAPTCHA validation by checking the position where the user clicks on the image to verify if it is inside the circle that is cut.

The generated image is served in PNG format. The values of the rendered circles are stored in session variables for subsequent validation.

The size and colors of the image and the circles are configurable parameters.

###### 1. install using composer ######
```bash
composer require krowinski/one-click-captcha
```
###### 2. example ######
https://github.com/krowinski/one-click-captcha/blob/master/example/example.php

##### 3. docker test
```bash
docker build -t captcha .
docker run -p 8090:80 captcha
```
http://localhost:8090/example/example.php
