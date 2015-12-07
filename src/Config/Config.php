<?php

namespace OneClickCaptcha\Config;


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
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return int
     */
    public function getBackgroundHeight()
    {
        return $this->backgroundHeight;
    }

    /**
     * @param int $backgroundHeight
     */
    public function setBackgroundHeight($backgroundHeight)
    {
        $this->backgroundHeight = $backgroundHeight;
    }

    /**
     * @return int
     */
    public function getBackgroundWidth()
    {
        return $this->backgroundWidth;
    }

    /**
     * @param int $backgroundWidth
     */
    public function setBackgroundWidth($backgroundWidth)
    {
        $this->backgroundWidth = $backgroundWidth;
    }

    /**
     * @return int
     */
    public function getCircleAmount()
    {
        return $this->circleAmount;
    }

    /**
     * @param int $circleAmount
     */
    public function setCircleAmount($circleAmount)
    {
        $this->circleAmount = $circleAmount;
    }

    /**
     * @return string
     */
    public function getCircleColor()
    {
        return $this->circleColor;
    }

    /**
     * @param string $circleColor
     */
    public function setCircleColor($circleColor)
    {
        $this->circleColor = $circleColor;
    }

    /**
     * @return int
     */
    public function getCircleSize()
    {
        return $this->circleSize;
    }

    /**
     * @param int $circleSize
     */
    public function setCircleSize($circleSize)
    {
        $this->circleSize = $circleSize;
    }
}