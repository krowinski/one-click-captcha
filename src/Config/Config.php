<?php
declare(strict_types=1);

namespace OneClickCaptcha\Config;

/**
 * Class Config
 * @package OneClickCaptcha\Config
 */
class Config
{
    /**
     * background img width
     * @var int
     */
    private $backgroundWidth = 400;
    /**
     * background img height
     * @var int
     */
    private $backgroundHeight = 200;
    /**
     * Circle color
     * @var string
     */
    private $backgroundColor = '#000';
    /**
     * Fake circle amount
     * @var int
     */
    private $circleAmount = 3;
    /**
     * Circle size on img
     * @var int
     */
    private $circleSize = 60;
    /**
     * An image color resource
     * @var string
     */
    private $circleColor = '#FFF';

    /**
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     * @return Config
     */
    public function setBackgroundColor(string $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * @return int
     */
    public function getBackgroundHeight(): int
    {
        return $this->backgroundHeight;
    }

    /**
     * @param int $backgroundHeight
     * @return Config
     */
    public function setBackgroundHeight(int $backgroundHeight): self
    {
        $this->backgroundHeight = $backgroundHeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getBackgroundWidth(): int
    {
        return $this->backgroundWidth;
    }

    /**
     * @param int $backgroundWidth
     * @return Config
     */
    public function setBackgroundWidth(int $backgroundWidth): self
    {
        $this->backgroundWidth = $backgroundWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function getCircleAmount(): int
    {
        return $this->circleAmount;
    }

    /**
     * @param int $circleAmount
     * @return Config
     */
    public function setCircleAmount(int $circleAmount): self
    {
        $this->circleAmount = $circleAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCircleColor(): string
    {
        return $this->circleColor;
    }

    /**
     * @param string $circleColor
     * @return Config
     */
    public function setCircleColor(string $circleColor): self
    {
        $this->circleColor = $circleColor;

        return $this;
    }

    /**
     * @return int
     */
    public function getCircleSize(): int
    {
        return $this->circleSize;
    }

    /**
     * @param int $circleSize
     * @return Config
     */
    public function setCircleSize(int $circleSize): self
    {
        $this->circleSize = $circleSize;

        return $this;
    }
}