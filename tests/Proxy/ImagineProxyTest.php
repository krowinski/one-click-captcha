<?php

use OneClickCaptcha\Proxy\ImagineProxy;

class ImagineProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImagineProxy
     */
    private $imagineProxy;

    public function setUp()
    {
        /**
         * @var Imagine\Image\ImagineInterface $stub
         */
        $stub = $this->getMockBuilder('Imagine\Image\ImagineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->imagineProxy = new ImagineProxy($stub);
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfBox()
    {
        $this->assertInstanceOf('Imagine\Image\Box', $this->imagineProxy->getBox(1, 1));
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfPoint()
    {
        $this->assertInstanceOf('Imagine\Image\Point', $this->imagineProxy->getPoint(1, 1));
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfRGB()
    {
        $this->assertInstanceOf('Imagine\Image\Palette\RGB', $this->imagineProxy->getRGB());
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfImagine()
    {
        $this->assertInstanceOf('Imagine\Image\ImagineInterface', $this->imagineProxy->getImagine());
    }
}