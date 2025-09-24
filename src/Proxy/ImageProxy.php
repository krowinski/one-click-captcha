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

readonly class ImageProxy
{
    public function __construct(
        private ImagineInterface $image
    ) {
    }

    public function getBox(int $width, int $height): BoxInterface
    {
        return new Box($width, $height);
    }

    public function getPoint(int $x, int $y): PointInterface
    {
        return new Point($x, $y);
    }

    public function getRGB(): PaletteInterface
    {
        return new RGB();
    }

    public function getImage(): ImagineInterface
    {
        return $this->image;
    }
}
