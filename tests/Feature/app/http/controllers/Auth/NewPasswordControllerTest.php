<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\NewPasswordController;
use Tests\TestCase;

/**
 * Class NewPasswordControllerTest.
 *
 * @covers \App\Http\Controllers\Auth\NewPasswordController
 */
final class NewPasswordControllerTest extends TestCase
{
    private NewPasswordController $newPasswordController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->newPasswordController = new NewPasswordController();
        $this->app->instance(NewPasswordController::class, $this->newPasswordController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->newPasswordController);
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
