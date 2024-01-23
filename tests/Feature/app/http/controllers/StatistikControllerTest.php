<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\StatistikController;
use Tests\TestCase;

/**
 * Class StatistikControllerTest.
 *
 * @covers \App\Http\Controllers\StatistikController
 */
final class StatistikControllerTest extends TestCase
{
    private StatistikController $statistikController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->statistikController = new StatistikController();
        $this->app->instance(StatistikController::class, $this->statistikController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->statistikController);
    }

    public function testStatistik_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
