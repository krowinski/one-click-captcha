<?php

namespace OneClickCaptcha\Service;

use Imagine\Draw\DrawerInterface;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Repository\Post;
use OneClickCaptcha\Proxy\ImagineProxy;

/**
 * Class OneClickCaptchaService
 * @package OneClickCaptcha\Service
 */
class OneClickCaptchaService
{
    /**
     * @var DrawerInterface
     */
    private $draw;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @param Config $config
     * @param Post $post
     * @param ImagineProxy $imagine
     */
    public function __construct(Config $config, Post $post, ImagineProxy $imagine)
    {
        $this->config = $config;
        $this->post = $post;
        $this->imagine = $imagine;
    }

    /**
     * Generate image
     */
    public function showCaptcha()
    {
        $image = $this->imagine->getImagine()->create(
            $this->imagine->getBox($this->config->getBackgroundWidth(), $this->config->getBackgroundHeight()),
            $this->imagine->getRGB()->color($this->config->getBackgroundColor(), 100)
        );
        $this->draw = $image->draw();

        for ($i = 1; $i <= $this->config->getCircleAmount(); ++$i) {
            $this->generateCircle(true);
        }
        $this->generateCircle(false);

        header('Pragma: public');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: public');

        $image->show('png');
    }

    /**
     * Validates if clicked circle is correct one.
     * @param $positionX
     * @param $positionY
     * @return bool
     */
    public function validate($positionX, $positionY)
    {
        if (is_numeric($positionX) and is_numeric($positionY)) {
            $this->post->saveLastRequest($positionX, $positionY);

            $distance = self::calculateDistance(
                $positionX,
                $this->post->get(Post::POSITION_X),
                $positionY,
                $this->post->get(Post::POSITION_Y)
            );
            if ($distance < $this->post->get(Post::RADIUS)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generates circles.
     * @param bool $createBreakCircle
     */
    private function generateCircle($createBreakCircle)
    {
        $min = $this->config->getCircleSize() / 2;
        $this->x = $this->getRandomX($min);
        $this->y = $this->getRandomY($min);

        if (true === $createBreakCircle) {
            $start = 0;
            $end = 360;
        } else {
            // decrease probability of clicking x times same place and hit correct one.
            $this->moveAwayFromLastClick($min);

            // save circle position
            $this->post->save($this->x, $this->y, $min);

            // "move" cut circle
            $z1 = mt_rand(-340, 0);
            $z1_left = 340 + $z1;

            $z2 = mt_rand(0, 340);
            $z2_left = 340 - $z2;

            $z2 += $z1_left;
            $z1 -= $z2_left;

            $start = $z1;
            $end = $z2;
        }

        $this->draw->arc(
            $this->imagine->getPoint($this->x, $this->y),
            $this->imagine->getBox($this->config->getCircleSize(), $this->config->getCircleSize()),
            $start,
            $end,
            $this->imagine->getRGB()->color($this->config->getCircleColor())
        );
    }

    /**
     * @param float $min
     */
    private function moveAwayFromLastClick($min)
    {
        if (!is_null($this->post->get(Post::LAST_REQUEST))) {
            while (true) {
                if ($min < self::calculateDistance(
                        $this->post->get(Post::LAST_REQUEST)[Post::POSITION_X],
                        $this->x,
                        $this->post->get(Post::LAST_REQUEST)[Post::POSITION_Y],
                        $this->y
                    )
                ) {
                    break;
                }

                // change position and try again
                $this->x = $this->getRandomX($min);
                $this->y = $this->getRandomY($min);
            }
        }
    }

    /**
     * Calculate distance using pattern to find point in the circle.
     * @param int $mx
     * @param int $cx
     * @param int $my
     * @param int $cy
     * @return float
     */
    private static function calculateDistance($mx, $cx, $my, $cy)
    {
        return round(sqrt(($mx - $cx) * ($mx - $cx) + ($my - $cy) * ($my - $cy)));
    }

    /**
     * @param float $min
     * @return int
     */
    private function getRandomX($min)
    {
        return mt_rand($min, $this->config->getBackgroundWidth() - $min);

    }

    /**
     * @param float $min
     * @return int
     */
    private function getRandomY($min)
    {
        return mt_rand($min, $this->config->getBackgroundHeight() - $min);
    }
}