<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\SchiffstrafficController;
use Tests\TestCase;

/**
 * Class SchiffstrafficControllerTest.
 *
 * @covers \App\Http\Controllers\SchiffstrafficController
 */
final class SchiffstrafficControllerTest extends TestCase
{
    private SchiffstrafficController $schiffstrafficController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->schiffstrafficController = new SchiffstrafficController();
        $this->app->instance(SchiffstrafficController::class, $this->schiffstrafficController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->schiffstrafficController);
    }

    public function testSchiffe_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
