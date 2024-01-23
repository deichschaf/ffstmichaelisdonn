<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use Tests\TestCase;

/**
 * Class EmailVerificationNotificationControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\EmailVerificationNotificationController
 */
final class EmailVerificationNotificationControllerTest extends TestCase
{
    private EmailVerificationNotificationController $emailVerificationNotificationController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->emailVerificationNotificationController = new EmailVerificationNotificationController();
        $this->app->instance(EmailVerificationNotificationController::class, $this->emailVerificationNotificationController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->emailVerificationNotificationController);
    }

    public function testStore(): void
    {
        /** @todo This test is incomplete. */
        $this->post('/path', [ /* data */ ])
            ->assertStatus(200);
    }
}
