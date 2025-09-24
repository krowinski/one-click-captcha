<?php

declare(strict_types=1);

namespace OneClickCaptcha\Repository;

interface StorageInterface
{
    public const string POSITION_X = 'positionX';
    public const string POSITION_Y = 'positionY';
    public const string RADIUS = 'radius';
    public const string LAST_REQUEST = 'last_position';

    public function save(int $positionX, int $positionY, float $radius): void;
    public function get(string $name): mixed;
    public function saveLastRequest(int $positionX, int $positionY): void;

    /**
     * @return array<string, int>
     */
    public function getLastRequest(): ?array;
}
