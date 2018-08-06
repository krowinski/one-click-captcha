<?php
declare(strict_types=1);

use OneClickCaptcha\Repository\SessionStorageInterfaceRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class SessionPostRepositoryTest
 */
class SessionPostRepositoryTest extends TestCase
{
    /**
     * @var SessionStorageInterfaceRepository
     */
    private $sessionPostRepository;

    public function setUp()
    {
        $this->sessionPostRepository = new SessionStorageInterfaceRepository();
    }

    /**
     * @test
     */
    public function shouldStartSession(): void
    {
        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
    }

    /**
     * @test
     */
    public function shouldSave(): void
    {
        $this->sessionPostRepository->save(1, 2, 3);

        $this->assertEquals(1, $this->sessionPostRepository->get(SessionStorageInterfaceRepository::POSITION_X));
        $this->assertEquals(2, $this->sessionPostRepository->get(SessionStorageInterfaceRepository::POSITION_Y));
        $this->assertEquals(3, $this->sessionPostRepository->get(SessionStorageInterfaceRepository::RADIUS));
    }

    /**
     * @test
     */
    public function shouldSaveLastRequest(): void
    {
        $this->sessionPostRepository->saveLastRequest(2, 3);

        $this->assertEquals(
            [SessionStorageInterfaceRepository::POSITION_X => 2, SessionStorageInterfaceRepository::POSITION_Y => 3],
            $this->sessionPostRepository->get(SessionStorageInterfaceRepository::LAST_REQUEST)
        );
    }

    /**
     * @test
     */
    public function shouldGetNULL(): void
    {
        $this->assertEquals(null, $this->sessionPostRepository->get('foo'));
    }
}