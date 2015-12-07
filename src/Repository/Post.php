<?php
namespace OneClickCaptcha\Repository;

interface Post
{
    const POSITION_X = 'positionX';
    const POSITION_Y = 'positionY';
    const RADIUS = 'radius';
    const LAST_REQUEST = 'last_position';

    /**
     * @param int $positionX
     * @param int $positionY
     * @param float $radius
     */
    public function save($positionX, $positionY, $radius);

    /**
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     *
     */
    public function saveLastRequest($positionX, $positionY);
}