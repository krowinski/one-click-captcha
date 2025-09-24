<?php

declare(strict_types=1);

use OneClickCaptcha\Repository\SessionStorage;
use OneClickCaptcha\Repository\StorageInterface;
use PHPUnit\Framework\TestCase;

class SessionStorageTest extends TestCase
{
    private SessionStorage $sessionPostRepository;

    protected function setUp(): void
    {
        $this->sessionPostRepository = new SessionStorage();
    }

    /**
     *
     */
    public function testShouldStartSession(): void
    {
        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
    }

    /**
     *
     */
    public function testShouldSave(): void
    {
        $this->sessionPostRepository->save(1, 2, 3);

        $this->assertEquals(1, $this->sessionPostRepository->get(StorageInterface::POSITION_X));
        $this->assertEquals(2, $this->sessionPostRepository->get(StorageInterface::POSITION_Y));
        $this->assertEquals(3, $this->sessionPostRepository->get(StorageInterface::RADIUS));
    }

    /**
     *
     */
    public function testShouldSaveLastRequest(): void
    {
        $this->sessionPostRepository->saveLastRequest(2, 3);

        $this->assertEquals(
            [
                StorageInterface::POSITION_X => 2,
                StorageInterface::POSITION_Y => 3,
            ],
            $this->sessionPostRepository->get(StorageInterface::LAST_REQUEST)
        );
    }

    /**
     *
     */
    public function testShouldGetNULL(): void
    {
        $this->assertEquals(null, $this->sessionPostRepository->get('foo'));
    }
}
