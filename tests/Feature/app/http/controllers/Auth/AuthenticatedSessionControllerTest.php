<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Tests\TestCase;

/**
 * Class AuthenticatedSessionControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\AuthenticatedSessionController
 */
final class AuthenticatedSessionControllerTest extends TestCase
{
    private AuthenticatedSessionController $authenticatedSessionController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->authenticatedSessionController = new AuthenticatedSessionController();
        $this->app->instance(AuthenticatedSessionController::class, $this->authenticatedSessionController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->authenticatedSessionController);
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

    public function testDestroy(): void
    {
        /** @todo This test is incomplete. */
        $this->delete('/path')
            ->assertStatus(200);
    }
}
