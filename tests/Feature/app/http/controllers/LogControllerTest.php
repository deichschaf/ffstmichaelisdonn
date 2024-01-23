<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\LogController;
use Tests\TestCase;

/**
 * Class LogControllerTest.
 *
 * @covers \App\Http\Controllers\LogController
 */
final class LogControllerTest extends TestCase
{
    private LogController $logController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->logController = new LogController();
        $this->app->instance(LogController::class, $this->logController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->logController);
    }

    public function testLog(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
