<?php
declare(strict_types=1);

namespace OneClickCaptcha\Proxy;

use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\PaletteInterface;
use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;
use Imagine\Image\PointInterface;

/**
 * Class ImagineProxy
 * @package OneClickCaptcha\Proxy
 */
class ImageProxy
{
    /**
     * @var ImagineInterface
     */
    private $image;

    /**
     * ImagineProxy constructor.
     * @param ImagineInterface $imagine
     */
    public function __construct(ImagineInterface $imagine)
    {
        $this->image = $imagine;
    }

    /**
     * @param int $width
     * @param int $height
     * @return BoxInterface
     */
    public function getBox(int $width, int $height): BoxInterface
    {
        return new Box($width, $height);
    }

    /**
     * @param int $x
     * @param int $y
     * @return PointInterface
     */
    public function getPoint(int $x, int $y): PointInterface
    {
        return new Point($x, $y);
    }

    /**
     * @return PaletteInterface
     */
    public function getRGB(): PaletteInterface
    {
        return new RGB();
    }

    /**
     * @return ImagineInterface
     */
    public function getImage(): ImagineInterface
    {
        return $this->image;
    }
}