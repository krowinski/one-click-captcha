<?php
declare(strict_types=1);

use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use OneClickCaptcha\Proxy\ImageProxy;
use PHPUnit\Framework\TestCase;

/**
 * Class ImagineProxyTest
 */
class ImagineProxyTest extends TestCase
{
    /**
     * @var ImageProxy
     */
    private $imagineProxy;

    public function setUp()
    {
        /**
         * @var Imagine\Image\ImagineInterface $stub
         */
        $stub = $this->getMockBuilder(ImagineInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->imagineProxy = new ImageProxy($stub);
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfBox(): void
    {
        $this->assertInstanceOf(Box::class, $this->imagineProxy->getBox(1, 1));
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfPoint(): void
    {
        $this->assertInstanceOf(Point::class, $this->imagineProxy->getPoint(1, 1));
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfRGB(): void
    {
        $this->assertInstanceOf(RGB::class, $this->imagineProxy->getRGB());
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfImagine(): void
    {
        $this->assertInstanceOf(ImagineInterface::class, $this->imagineProxy->getImage());
    }
}