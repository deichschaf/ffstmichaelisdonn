<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisteredUserController;
use Tests\TestCase;

/**
 * Class RegisteredUserControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\RegisteredUserController
 */
final class RegisteredUserControllerTest extends TestCase
{
    private RegisteredUserController $registeredUserController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->registeredUserController = new RegisteredUserController();
        $this->app->instance(RegisteredUserController::class, $this->registeredUserController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->registeredUserController);
    }

    public function testCreate(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testStore(): void
    {
        /** @todo This test is incomplete. */
        $this->post('/path', [ /* data */ ])
            ->assertStatus(200);
    }
}
