<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\EinsaetzeController;
use Tests\TestCase;

/**
 * Class EinsaetzeControllerTest.
 *
 * @covers \App\Http\Controllers\EinsaetzeController
 */
final class EinsaetzeControllerTest extends TestCase
{
    private EinsaetzeController $einsaetzeController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->einsaetzeController = new EinsaetzeController();
        $this->app->instance(EinsaetzeController::class, $this->einsaetzeController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->einsaetzeController);
    }

    public function testEmergencyOverviewApi(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testSaveData(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testGetLastEmergency(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testPreDataApi(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShow_schadensliste(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testSchadensliste_loader(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testEinsatz_statistik_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testEinsaetze_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
