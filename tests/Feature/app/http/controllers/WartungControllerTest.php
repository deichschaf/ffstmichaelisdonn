<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\WartungController;
use Tests\TestCase;

/**
 * Class WartungControllerTest.
 *
 * @covers \App\Http\Controllers\WartungController
 */
final class WartungControllerTest extends TestCase
{
    private WartungController $wartungController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->wartungController = new WartungController();
        $this->app->instance(WartungController::class, $this->wartungController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->wartungController);
    }

    public function testGetWartung(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testErrorWartung(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testWriteLog(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testSendErrorMail(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testBuildPage(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
