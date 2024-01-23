<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use Tests\TestCase;

/**
 * Class PasswordResetLinkControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\PasswordResetLinkController
 */
final class PasswordResetLinkControllerTest extends TestCase
{
    private PasswordResetLinkController $passwordResetLinkController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->passwordResetLinkController = new PasswordResetLinkController();
        $this->app->instance(PasswordResetLinkController::class, $this->passwordResetLinkController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->passwordResetLinkController);
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
