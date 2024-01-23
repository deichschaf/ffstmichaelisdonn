<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\AnwesenheitController;
use Tests\TestCase;

/**
 * Class AnwesenheitControllerTest.
 *
 * @covers \App\Http\Controllers\AnwesenheitController
 */
final class AnwesenheitControllerTest extends TestCase
{
    private AnwesenheitController $anwesenheitController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->anwesenheitController = new AnwesenheitController();
        $this->app->instance(AnwesenheitController::class, $this->anwesenheitController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->anwesenheitController);
    }

    public function testShow_start(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testGetMitglieder(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testEinsatz(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testUebung(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAbsicherung(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testHydranten(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAnwesenheit_speichern(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testSaveStatus(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testSaveStatusText(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
