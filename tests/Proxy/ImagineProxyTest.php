<?php

declare(strict_types=1);

namespace Proxy;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;
use OneClickCaptcha\Proxy\ImageProxy;
use PHPUnit\Framework\TestCase;

class ImagineProxyTest extends TestCase
{
    /**
     * @var ImageProxy
     */
    private ImageProxy $imagineProxy;

    protected function setUp(): void
    {
        $stub = $this->getMockBuilder(ImagineInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->imagineProxy = new ImageProxy($stub);
    }

    /**
     *
     */
    public function testShouldReturnInstanceOfBox(): void
    {
        $this->assertInstanceOf(Box::class, $this->imagineProxy->getBox(1, 1));
    }

    /**
     *
     */
    public function testShouldReturnInstanceOfPoint(): void
    {
        $this->assertInstanceOf(Point::class, $this->imagineProxy->getPoint(1, 1));
    }

    /**
     *
     */
    public function testShouldReturnInstanceOfRGB(): void
    {
        $this->assertInstanceOf(RGB::class, $this->imagineProxy->getRGB());
    }

    /**
     *
     */
    public function testShouldReturnInstanceOfImagine(): void
    {
        $this->assertInstanceOf(ImagineInterface::class, $this->imagineProxy->getImage());
    }
}
