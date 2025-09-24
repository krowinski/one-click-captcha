<?php

declare(strict_types=1);

namespace OneClickCaptcha\Config;

class Config
{
    /**
     * Background img width
     */
    private int $backgroundWidth = 400;
    /**
     * Background img height
     */
    private int $backgroundHeight = 200;
    /**
     * Image color
     */
    private string $backgroundColor = '#000';
    /**
     * Fake circle amount
     */
    private int $circleAmount = 3;
    /**
     * Circle size on img
     */
    private int $circleSize = 60;
    /**
     * Circle colors
     */
    private string $circleColor = '#FFF';

    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function getBackgroundHeight(): int
    {
        return $this->backgroundHeight;
    }

    public function setBackgroundHeight(int $backgroundHeight): self
    {
        $this->backgroundHeight = $backgroundHeight;

        return $this;
    }

    public function getBackgroundWidth(): int
    {
        return $this->backgroundWidth;
    }

    public function setBackgroundWidth(int $backgroundWidth): self
    {
        $this->backgroundWidth = $backgroundWidth;

        return $this;
    }

    public function getCircleAmount(): int
    {
        return $this->circleAmount;
    }

    public function setCircleAmount(int $circleAmount): self
    {
        $this->circleAmount = $circleAmount;

        return $this;
    }

    public function getCircleColor(): string
    {
        return $this->circleColor;
    }

    public function setCircleColor(string $circleColor): self
    {
        $this->circleColor = $circleColor;

        return $this;
    }

    public function getCircleSize(): int
    {
        return $this->circleSize;
    }

    public function setCircleSize(int $circleSize): self
    {
        $this->circleSize = $circleSize;

        return $this;
    }
}
