<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FeuerwehrController;
use Tests\TestCase;

/**
 * Class FeuerwehrControllerTest.
 *
 * @covers \App\Http\Controllers\FeuerwehrController
 */
final class FeuerwehrControllerTest extends TestCase
{
    private FeuerwehrController $feuerwehrController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->feuerwehrController = new FeuerwehrController();
        $this->app->instance(FeuerwehrController::class, $this->feuerwehrController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->feuerwehrController);
    }

    public function testDienstgrade(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdd_fire_contactform(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testSend_fire_contactform(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
