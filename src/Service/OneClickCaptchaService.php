<?php

declare(strict_types=1);

namespace OneClickCaptcha\Service;

use Exception;
use Imagine\Draw\DrawerInterface;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Proxy\ImageProxy;
use OneClickCaptcha\Repository\StorageInterface;
use RuntimeException;

class OneClickCaptchaService
{
    private DrawerInterface $draw;
    private int $x = 0;
    private int $y = 0;

    public function __construct(
        private readonly Config $config,
        private readonly StorageInterface $storage,
        private readonly ImageProxy $image
    ) {
    }

    public function renderCaptcha(): void
    {
        $image = $this->image->getImage()
            ->create(
                $this->image->getBox($this->config->getBackgroundWidth(), $this->config->getBackgroundHeight()),
                $this->image->getRGB()
                    ->color($this->config->getBackgroundColor(), 100)
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
     */
    public function validate(int $positionX, int $positionY): bool
    {
        $this->storage->saveLastRequest($positionX, $positionY);
        $distance = self::calculateDistance(
            $positionX,
            $this->storage->get(StorageInterface::POSITION_X),
            $positionY,
            $this->storage->get(StorageInterface::POSITION_Y)
        );

        return $distance < $this->storage->get(StorageInterface::RADIUS);
    }

    /**
     * Generates circles.
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
            $this->storage->save($this->x, $this->y, $min);

            // "move" cut circle
            $z1 = self::rand(-340, 0);
            $z1Left = 340 + $z1;

            $z2 = self::rand(0, 340);
            $z2Left = 340 - $z2;

            $z2 += $z1Left;
            $z1 -= $z2Left;

            $start = $z1;
            $end = $z2;
        }

        $this->draw->arc(
            $this->image->getPoint($this->x, $this->y),
            $this->image->getBox($this->config->getCircleSize(), $this->config->getCircleSize()),
            $start,
            $end,
            $this->image->getRGB()
                ->color($this->config->getCircleColor())
        );
    }

    private function getRandomX(int $min): int
    {
        return self::rand($min, $this->config->getBackgroundWidth() - $min);
    }

    private static function rand(int $min, int $max): int
    {
        try {
            return random_int($min, $max);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getRandomY(int $min): int
    {
        return self::rand($min, $this->config->getBackgroundHeight() - $min);
    }

    private function moveAwayFromLastClick(int $min): void
    {
        $lastRequest = $this->storage->getLastRequest();
        if ($lastRequest !== null) {
            while (true) {
                if ($min < self::calculateDistance(
                    $lastRequest[StorageInterface::POSITION_X],
                    $this->x,
                    $lastRequest[StorageInterface::POSITION_Y],
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
     */
    private static function calculateDistance(int $mx, int $cx, int $my, int $cy): int
    {
        return (int)round(sqrt(($mx - $cx) * ($mx - $cx) + ($my - $cy) * ($my - $cy)));
    }
}
