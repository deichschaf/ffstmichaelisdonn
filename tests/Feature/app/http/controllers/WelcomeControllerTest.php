<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\WelcomeController;
use Tests\TestCase;

/**
 * Class WelcomeControllerTest.
 *
 * @covers \App\Http\Controllers\WelcomeController
 */
final class WelcomeControllerTest extends TestCase
{
    private WelcomeController $welcomeController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->welcomeController = new WelcomeController();
        $this->app->instance(WelcomeController::class, $this->welcomeController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->welcomeController);
    }

    public function testIndex(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
