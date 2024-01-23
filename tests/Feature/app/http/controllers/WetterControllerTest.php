<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\WetterController;
use Tests\TestCase;

/**
 * Class WetterControllerTest.
 *
 * @covers \App\Http\Controllers\WetterController
 */
final class WetterControllerTest extends TestCase
{
    private WetterController $wetterController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->wetterController = new WetterController();
        $this->app->instance(WetterController::class, $this->wetterController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->wetterController);
    }

    public function testWetter(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testUnwetter(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
