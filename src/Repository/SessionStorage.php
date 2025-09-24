<?php

declare(strict_types=1);

namespace OneClickCaptcha\Repository;

class SessionStorage implements StorageInterface
{
    public const string NAME = 'oneClickCaptcha';

    public function __construct()
    {
        // start session if is not started already
        if (headers_sent() === false && session_id() === '') {
            session_start();
        }
    }

    public function save(int $positionX, int $positionY, float $radius): void
    {
        $_SESSION[self::NAME] = [
            self::POSITION_X => $positionX,
            self::POSITION_Y => $positionY,
            self::RADIUS => $radius,
        ];
    }

    public function get(string $name): mixed
    {
        return $_SESSION[self::NAME][$name] ?? null;
    }

    public function saveLastRequest(int $positionX, int $positionY): void
    {
        $_SESSION[self::NAME][self::LAST_REQUEST] = [
            self::POSITION_X => $positionX,
            self::POSITION_Y => $positionY,
        ];
    }

    public function getLastRequest(): ?array
    {
        return $_SESSION[self::NAME][self::LAST_REQUEST] ?? null;
    }
}
