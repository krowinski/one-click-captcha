<?php
declare(strict_types=1);

namespace OneClickCaptcha\Service;

use Imagine\Draw\DrawerInterface;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Repository\StorageInterface;
use OneClickCaptcha\Proxy\ImageProxy;

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
     * @var Config
     */
    private $config;
    /**
     * @var StorageInterface
     */
    private $post;
    /**
     * @var ImageProxy
     */
    private $image;
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
     * @param StorageInterface $post
     * @param ImageProxy $image
     */
    public function __construct(
        Config $config,
        StorageInterface $post,
        ImageProxy $image
    ) {
        $this->config = $config;
        $this->post = $post;
        $this->image = $image;
    }

    /**
     * Generate image
     * @throws \Exception
     */
    public function showCaptcha(): void
    {
        $image = $this->image->getImage()->create(
            $this->image->getBox($this->config->getBackgroundWidth(), $this->config->getBackgroundHeight()),
            $this->image->getRGB()->color($this->config->getBackgroundColor(), 100)
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
     * Generates circles.
     * @param bool $createBreakCircle
     * @throws \Exception
     */
    private function generateCircle(bool $createBreakCircle): void
    {
        $min = (int)round($this->config->getCircleSize() / 2);
        $this->x = $this->getRandomX($min);
        $this->y = $this->getRandomY($min);

        if ($createBreakCircle) {
            $start = 0;
            $end = 360;
        } else {
            // decrease probability of clicking x times same place and hit correct one.
            $this->moveAwayFromLastClick($min);

            // save circle position
            $this->post->save($this->x, $this->y, $min);

            // "move" cut circle
            $z1 = random_int(-340, 0);
            $z1_left = 340 + $z1;

            $z2 = random_int(0, 340);
            $z2_left = 340 - $z2;

            $z2 += $z1_left;
            $z1 -= $z2_left;

            $start = $z1;
            $end = $z2;
        }

        $this->draw->arc(
            $this->image->getPoint($this->x, $this->y),
            $this->image->getBox($this->config->getCircleSize(), $this->config->getCircleSize()),
            $start,
            $end,
            $this->image->getRGB()->color($this->config->getCircleColor())
        );
    }

    /**
     * @param int $min
     * @return int
     * @throws \Exception
     */
    private function getRandomX(int $min): int
    {
        return random_int($min, $this->config->getBackgroundWidth() - $min);

    }

    /**
     * @param int $min
     * @return int
     * @throws \Exception
     */
    private function getRandomY(int $min): int
    {
        return random_int($min, $this->config->getBackgroundHeight() - $min);
    }

    /**
     * @param int $min
     * @throws \Exception
     */
    private function moveAwayFromLastClick(int $min): void
    {
        if (null !== $this->post->get(StorageInterface::LAST_REQUEST)) {
            while (true) {
                if ($min < self::calculateDistance(
                        $this->post->get(StorageInterface::LAST_REQUEST)[StorageInterface::POSITION_X],
                        $this->x,
                        $this->post->get(StorageInterface::LAST_REQUEST)[StorageInterface::POSITION_Y],
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
     * @return int
     */
    private static function calculateDistance(int $mx, int $cx, int $my, int $cy): int
    {
        return (int)round(sqrt(($mx - $cx) * ($mx - $cx) + ($my - $cy) * ($my - $cy)));
    }

    /**
     * Validates if clicked circle is correct one.
     * @param int $positionX
     * @param int $positionY
     * @return bool
     */
    public function validate(int $positionX, int $positionY): bool
    {
        $this->post->saveLastRequest($positionX, $positionY);
        $distance = self::calculateDistance(
            $positionX,
            $this->post->get(StorageInterface::POSITION_X),
            $positionY,
            $this->post->get(StorageInterface::POSITION_Y)
        );

        return $distance < $this->post->get(StorageInterface::RADIUS);
    }
}