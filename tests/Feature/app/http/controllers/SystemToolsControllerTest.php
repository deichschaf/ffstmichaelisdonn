<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\SystemToolsController;
use Tests\TestCase;

/**
 * Class SystemToolsControllerTest.
 *
 * @covers \App\Http\Controllers\SystemToolsController
 */
final class SystemToolsControllerTest extends TestCase
{
    private SystemToolsController $systemToolsController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->systemToolsController = new SystemToolsController();
        $this->app->instance(SystemToolsController::class, $this->systemToolsController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->systemToolsController);
    }

    public function testSystemtools_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testMakeCacheClear(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
