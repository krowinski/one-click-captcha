<?php

declare(strict_types=1);

namespace Service;

use Imagine\Draw\DrawerInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\Color\ColorInterface;
use Imagine\Image\Palette\PaletteInterface;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Proxy\ImageProxy;
use OneClickCaptcha\Repository\StorageInterface;
use OneClickCaptcha\Service\OneClickCaptchaService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OneClickCaptchaServiceTest extends TestCase
{
    /**
     * @var OneClickCaptchaService
     */
    private OneClickCaptchaService $oneClickCaptchaService;

    protected function setUp(): void
    {
        $configStub = new Config();
        /** @var StorageInterface|MockObject $postStub */
        $postStub = $this->createMock(StorageInterface::class);
        $postStub->method('get')
            ->willReturnCallback(
                static function ($name) {
                    if ($name === StorageInterface::LAST_REQUEST) {
                        return [
                            StorageInterface::POSITION_X => 1,
                            StorageInterface::POSITION_Y => 1,
                        ];
                    }

                    return 1;
                }
            );

        $imageInterface = $this->createMock(ImageInterface::class);
        $imageInterface->method('draw')
            ->willReturn($this->createMock(DrawerInterface::class));

        $imagineInterfaceStub = $this->createMock(ImagineInterface::class);
        $imagineInterfaceStub->method('create')
            ->willReturn($imageInterface);

        $palette = $this->createMock(PaletteInterface::class);
        $palette->method('color')
            ->willReturn($this->createMock(ColorInterface::class));

        /** @var ImageProxy|MockObject $imagineProxyStub */
        $imagineProxyStub = $this->createMock(ImageProxy::class);
        $imagineProxyStub->method('getImage')
            ->willReturn($imagineInterfaceStub);
        $imagineProxyStub->method('getRGB')
            ->willReturn($palette);

        $this->oneClickCaptchaService = new OneClickCaptchaService($configStub, $postStub, $imagineProxyStub);
    }

    /**
     *
     */
    public function testShouldShowCaptcha(): void
    {
        $this->oneClickCaptchaService->renderCaptcha();

        $this->expectNotToPerformAssertions();
    }

    /**
     *
     */
    public function testShouldValidate(): void
    {
        $this->assertFalse($this->oneClickCaptchaService->validate(-1, -5));
        $this->assertFalse($this->oneClickCaptchaService->validate(2, 2));
        $this->assertTrue($this->oneClickCaptchaService->validate(1, 1));
    }
}
