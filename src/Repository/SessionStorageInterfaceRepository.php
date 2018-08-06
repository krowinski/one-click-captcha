<?php
declare(strict_types=1);

namespace OneClickCaptcha\Repository;

/**
 * Class SessionPostRepository
 * @package OneClickCaptcha\Repository
 */
class SessionStorageInterfaceRepository implements StorageInterface
{
    public const NAME = 'oneClickCaptcha';

    public function __construct()
    {
        // start session if is not started already
        if (false === headers_sent() && '' === session_id()) {
            session_start();
        }
    }

    /**
     * @param int $positionX
     * @param int $positionY
     * @param float $radius
     */
    public function save(int $positionX, int $positionY, float $radius): void
    {
        $_SESSION[self::NAME] = [
            self::POSITION_X => $positionX,
            self::POSITION_Y => $positionY,
            self::RADIUS     => $radius,
        ];
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        if (isset($_SESSION[self::NAME][$name])) {
            return $_SESSION[self::NAME][$name];
        }

        return null;
    }

    /**
     * @param int $positionX
     * @param int $positionY
     */
    public function saveLastRequest(int $positionX, int $positionY): void
    {
        $_SESSION[self::NAME][self::LAST_REQUEST] = [
            self::POSITION_X => $positionX,
            self::POSITION_Y => $positionY,
        ];
    }
}