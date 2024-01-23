<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\DashboardController;
use Tests\TestCase;

/**
 * Class DashboardControllerTest.
 *
 * @covers \App\Http\Controllers\DashboardController
 */
final class DashboardControllerTest extends TestCase
{
    private DashboardController $dashboardController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->dashboardController = new DashboardController();
        $this->app->instance(DashboardController::class, $this->dashboardController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dashboardController);
    }

    public function testDashboardOverview(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
