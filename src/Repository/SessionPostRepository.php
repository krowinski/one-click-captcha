<?php

namespace OneClickCaptcha\Repository;

class SessionPostRepository implements Post
{
    const NAME = 'oneClickCaptcha';

    /**
     *
     */
    public function __construct()
    {
        // start session if is not started already
        if (false === headers_sent() and '' == session_id()) {
            session_start();
        }
    }

    /**
     * @param int $positionX
     * @param int $positionY
     * @param float $radius
     */
    public function save($positionX, $positionY, $radius)
    {
        $_SESSION[self::NAME] = [
            self::POSITION_X => $positionX,
            self::POSITION_Y => $positionY,
            self::RADIUS => $radius
        ];
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (isset($_SESSION[self::NAME][$name])) {
            return $_SESSION[self::NAME][$name];
        }
        return null;
    }

    /**
     *
     */
    public function saveLastRequest($positionX, $positionY)
    {
        $_SESSION[self::NAME][self::LAST_REQUEST] = [
            self::POSITION_X => $positionX,
            self::POSITION_Y => $positionY
        ];
    }
}