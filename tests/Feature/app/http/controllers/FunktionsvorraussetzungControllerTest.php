<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FunktionsvorraussetzungController;
use Tests\TestCase;

/**
 * Class FunktionsvorraussetzungControllerTest.
 *
 * @covers \App\Http\Controllers\FunktionsvorraussetzungController
 */
final class FunktionsvorraussetzungControllerTest extends TestCase
{
    private FunktionsvorraussetzungController $funktionsvorraussetzungController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->funktionsvorraussetzungController = new FunktionsvorraussetzungController();
        $this->app->instance(FunktionsvorraussetzungController::class, $this->funktionsvorraussetzungController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->funktionsvorraussetzungController);
    }

    public function testFunction_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
