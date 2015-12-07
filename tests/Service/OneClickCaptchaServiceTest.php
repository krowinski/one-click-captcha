<?php

use Imagine\Draw\DrawerInterface;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Repository\Post;
use OneClickCaptcha\Proxy\ImagineProxy;
use OneClickCaptcha\Service\OneClickCaptchaService;


class OneClickCaptchaServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OneClickCaptchaService
     */
    private $oneClickCaptchaService;

    public function setUp()
    {
        $configStub = $this->getMockBuilder('OneClickCaptcha\Config\Config')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $postStub = $this->getMockBuilder('OneClickCaptcha\Repository\Post')
            ->disableOriginalConstructor()
            ->getMock();
        $postStub->method('get')->willReturnCallback(
            function ($name) {
                if (Post::LAST_REQUEST === $name)
                {
                    return [
                        Post::POSITION_X => 1,
                        Post::POSITION_Y => 1,
                    ];
                }
                return 1;
            }
        );

        $imagineProxyStub = $this->getMockBuilder('OneClickCaptcha\Proxy\ImagineProxy')
            ->disableOriginalConstructor()
            ->getMock();

        $ImagineInterfaceStub = $this->getMockBuilder('Imagine\Image\ImagineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $imageInterface = $this->getMockBuilder('Imagine\Image\ImageInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $imageInterface->method('draw')->willReturn(
            $this->getMockBuilder('Imagine\Draw\DrawerInterface')
                ->disableOriginalConstructor()
                ->getMock()
        );

        $ImagineInterfaceStub->method('create')->willReturn($imageInterface);

        $imagineProxyStub->method('getImagine')->willReturn($ImagineInterfaceStub);

        $rgnStub = $this->getMockBuilder('Imagine\Image\Palette\RGB')
            ->disableOriginalConstructor()
            ->getMock();
        $rgnStub->method('color')->willReturn(
            $this->getMockBuilder('Imagine\Image\Palette\Color\ColorInterface')
                ->disableOriginalConstructor()
                ->getMock()
        );

        $imagineProxyStub->method('getRGB')->willReturn(
            $rgnStub
        );

        $imagineProxyStub->method('getBox')->willReturn(
            $this->getMockBuilder('Imagine\Image\BoxInterface')
                ->disableOriginalConstructor()
                ->getMock()
        );

        $imagineProxyStub->method('getPoint')->willReturn(
            $this->getMockBuilder('Imagine\Image\PointInterface')
                ->disableOriginalConstructor()
                ->getMock()
        );

        $this->oneClickCaptchaService = new OneClickCaptchaService(
            $configStub,
            $postStub,
            $imagineProxyStub
        );
    }

    /**
     * @test
     */
    public function shouldShowCaptcha()
    {
        $this->oneClickCaptchaService->showCaptcha();

        $headers = xdebug_get_headers();

        $this->assertEquals("Expires: Thu, 19 Nov 1981 08:52:00 GMT", $headers[1]);
        $this->assertEquals("Pragma: public", $headers[2]);
        $this->assertEquals("Cache-Control: public", $headers[3]);
    }

    /**
     * @test
     */
    public function shouldValidate()
    {
        $this->assertFalse($this->oneClickCaptchaService->validate('foo', 'foo'));
        $this->assertFalse($this->oneClickCaptchaService->validate(2, 2));
        $this->assertTrue($this->oneClickCaptchaService->validate(1, 1));
    }

    /**
     * @test
     */
    public function shouldMoveAwayFromLastClick()
    {
        $reflection = new \ReflectionClass(get_class($this->oneClickCaptchaService));
        $method = $reflection->getMethod('moveAwayFromLastClick');
        $method->setAccessible(true);

        return $method->invokeArgs($this->oneClickCaptchaService, [1]);
    }
}