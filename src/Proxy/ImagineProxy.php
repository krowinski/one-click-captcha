<?php

namespace OneClickCaptcha\Proxy;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;

/**
 * Class ImagineProxy
 * @package OneClickCaptcha\Proxy
 */
class ImagineProxy
{
    public function __construct(ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * @param int $width
     * @param int $height
     * @return Box
     */
    public function getBox($width, $height)
    {
        return new Box($width, $height);
    }

    /**
     * @param int $x
     * @param int $y
     * @return Point
     */
    public function getPoint($x, $y)
    {
        return new Point($x, $y);
    }

    /**
     * @return RGB
     */
    public function getRGB()
    {
        return new RGB();
    }

    /**
     * @return ImagineInterface
     */
    public function getImagine()
    {
        return $this->imagine;
    }
}