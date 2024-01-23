<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\IndexController;
use Tests\TestCase;

/**
 * Class IndexControllerTest.
 *
 * @covers \App\Http\Controllers\IndexController
 */
final class IndexControllerTest extends TestCase
{
    private IndexController $indexController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->indexController = new IndexController();
        $this->app->instance(IndexController::class, $this->indexController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->indexController);
    }

    public function testIndex_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testLogin(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
