<?php

use OneClickCaptcha\Repository\SessionPostRepository;

class SessionPostRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SessionPostRepository
     */
    private $sessionPostRepository;

    public function setUp()
    {
        $this->sessionPostRepository = new SessionPostRepository();
    }

    /**
     * @test
     */
    public function shouldStartSession()
    {
        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
    }

    /**
     * @test
     */
    public function shouldSave()
    {
        $this->sessionPostRepository->save(1, 2, 3);

        $this->assertEquals(1, $this->sessionPostRepository->get(SessionPostRepository::POSITION_X));
        $this->assertEquals(2, $this->sessionPostRepository->get(SessionPostRepository::POSITION_Y));
        $this->assertEquals(3, $this->sessionPostRepository->get(SessionPostRepository::RADIUS));
    }

    /**
     * @test
     */
    public function shouldSaveLastRequest()
    {
        $this->sessionPostRepository->saveLastRequest(2, 3);

        $this->assertEquals(
            [SessionPostRepository::POSITION_X => 2, SessionPostRepository::POSITION_Y => 3],
            $this->sessionPostRepository->get(SessionPostRepository::LAST_REQUEST)
        );
    }

    /**
     * @test
     */
    public function shouldGetNULL()
    {
        $this->assertEquals(null, $this->sessionPostRepository->get('foo'));
    }
}