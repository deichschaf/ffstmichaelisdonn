<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\HomeController;
use Tests\TestCase;

/**
 * Class HomeControllerTest.
 *
 * @covers \App\Http\Controllers\HomeController
 */
final class HomeControllerTest extends TestCase
{
    private HomeController $homeController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->homeController = new HomeController();
        $this->app->instance(HomeController::class, $this->homeController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->homeController);
    }

    public function testIndex(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
