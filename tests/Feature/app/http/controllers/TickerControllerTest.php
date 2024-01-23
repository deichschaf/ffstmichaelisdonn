<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\TickerController;
use Tests\TestCase;

/**
 * Class TickerControllerTest.
 *
 * @covers \App\Http\Controllers\TickerController
 */
final class TickerControllerTest extends TestCase
{
    private TickerController $tickerController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->tickerController = new TickerController();
        $this->app->instance(TickerController::class, $this->tickerController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->tickerController);
    }

    public function testAdminShow(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminAdd(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminEdit(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminDelete(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminDeletePost(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminSave(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
