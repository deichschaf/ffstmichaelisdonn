<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\VerifyEmailController;
use Tests\TestCase;

/**
 * Class VerifyEmailControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\VerifyEmailController
 */
final class VerifyEmailControllerTest extends TestCase
{
    private VerifyEmailController $verifyEmailController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->verifyEmailController = new VerifyEmailController();
        $this->app->instance(VerifyEmailController::class, $this->verifyEmailController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->verifyEmailController);
    }

    public function test__invoke(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
