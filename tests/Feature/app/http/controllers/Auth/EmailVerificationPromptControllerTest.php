<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\EmailVerificationPromptController;
use Tests\TestCase;

/**
 * Class EmailVerificationPromptControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\EmailVerificationPromptController
 */
final class EmailVerificationPromptControllerTest extends TestCase
{
    private EmailVerificationPromptController $emailVerificationPromptController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->emailVerificationPromptController = new EmailVerificationPromptController();
        $this->app->instance(EmailVerificationPromptController::class, $this->emailVerificationPromptController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->emailVerificationPromptController);
    }

    public function test__invoke(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
