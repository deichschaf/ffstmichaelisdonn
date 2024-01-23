<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\KalenderController;
use Tests\TestCase;

/**
 * Class KalenderControllerTest.
 *
 * @covers \App\Http\Controllers\KalenderController
 */
final class KalenderControllerTest extends TestCase
{
    private KalenderController $kalenderController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->kalenderController = new KalenderController();
        $this->app->instance(KalenderController::class, $this->kalenderController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->kalenderController);
    }

    public function testCalender_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
