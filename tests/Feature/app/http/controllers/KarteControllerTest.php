<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\KarteController;
use Tests\TestCase;

/**
 * Class KarteControllerTest.
 *
 * @covers \App\Http\Controllers\KarteController
 */
final class KarteControllerTest extends TestCase
{
    private KarteController $karteController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->karteController = new KarteController();
        $this->app->instance(KarteController::class, $this->karteController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->karteController);
    }

    public function testShow_position(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testKarte_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testEinsatzgebiet(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShow_einsatz(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShow_ort(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdmin_einsatz(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
