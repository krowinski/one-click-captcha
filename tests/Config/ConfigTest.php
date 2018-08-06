<?php
declare(strict_types=1);

use OneClickCaptcha\Config\Config;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigTest
 */
class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    private $config;

    public function setUp()
    {
        $this->config = new Config();
    }

    /**
     * @test
     */
    public function shouldDefaultsBeSet(): void
    {
        $this->assertSame(400, $this->config->getBackgroundWidth());
        $this->assertSame(200, $this->config->getBackgroundHeight());
        $this->assertSame('#000', $this->config->getBackgroundColor());

        $this->assertSame(3, $this->config->getCircleAmount());
        $this->assertSame(60, $this->config->getCircleSize());
        $this->assertSame('#FFF', $this->config->getCircleColor());
    }

    /**
     * @test
     */
    public function shouldSettersSet(): void
    {
        $this->config->setBackgroundWidth(100);
        $this->assertSame(100, $this->config->getBackgroundWidth());

        $this->config->setBackgroundHeight(50);
        $this->assertSame(50, $this->config->getBackgroundHeight());

        $this->config->setBackgroundColor('#ABC');
        $this->assertSame('#ABC', $this->config->getBackgroundColor());

        $this->config->setCircleAmount(10);
        $this->assertSame(10, $this->config->getCircleAmount());

        $this->config->setCircleSize(180);
        $this->assertSame(180, $this->config->getCircleSize());

        $this->config->setCircleColor('#F00');
        $this->assertSame('#F00', $this->config->getCircleColor());
    }
}