[![Build Status](https://travis-ci.org/krowinski/one-click-captcha.svg?branch=1.2)](https://travis-ci.org/krowinski/one-click-captcha)

This lib can perform CAPTCHA validation based on user clicks on circles.

It render an image with several circles on random positions. Only one circle appears cut.

The class performs CAPTCHA validation by checking the position where the user clicks on the image to verify it it is inside of the circle that is cut.

The generated image is served in PNG format. The values of the rendered circles are stored in session variables for subsequent validation.

The size and colors of the image and the circles are configurable parameters.


