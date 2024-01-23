<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\DBUpdateController;
use Tests\TestCase;

/**
 * Class DBUpdateControllerTest.
 *
 * @covers \App\Http\Controllers\DBUpdateController
 */
final class DBUpdateControllerTest extends TestCase
{
    private DBUpdateController $dBUpdateController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->dBUpdateController = new DBUpdateController();
        $this->app->instance(DBUpdateController::class, $this->dBUpdateController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dBUpdateController);
    }

    public function testCheckLaravelColumns(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
