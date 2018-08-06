<?php
declare(strict_types=1);

namespace OneClickCaptcha\Repository;

/**
 * Interface PostInterface
 * @package OneClickCaptcha\Repository
 */
interface StorageInterface
{
    public const POSITION_X = 'positionX';
    public const POSITION_Y = 'positionY';
    public const RADIUS = 'radius';
    public const LAST_REQUEST = 'last_position';

    /**
     * @param int $positionX
     * @param int $positionY
     * @param float $radius
     */
    public function save(int $positionX, int $positionY, float $radius);

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param int $positionX
     * @param int $positionY
     */
    public function saveLastRequest(int $positionX, int $positionY): void;
}