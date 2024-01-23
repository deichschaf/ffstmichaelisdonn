<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\HiOrgsExportController;
use Tests\TestCase;

/**
 * Class HiOrgsExportControllerTest.
 *
 * @covers \App\Http\Controllers\HiOrgsExportController
 */
final class HiOrgsExportControllerTest extends TestCase
{
    private HiOrgsExportController $hiOrgsExportController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->hiOrgsExportController = new HiOrgsExportController();
        $this->app->instance(HiOrgsExportController::class, $this->hiOrgsExportController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->hiOrgsExportController);
    }

    public function testHiorg_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testGetRufnamenGemeinde(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
