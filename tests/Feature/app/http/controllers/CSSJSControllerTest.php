<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\CSSJSController;
use Tests\TestCase;

/**
 * Class CSSJSControllerTest.
 *
 * @covers \App\Http\Controllers\CSSJSController
 */
final class CSSJSControllerTest extends TestCase
{
    private CSSJSController $cSSJSController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->cSSJSController = new CSSJSController();
        $this->app->instance(CSSJSController::class, $this->cSSJSController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->cSSJSController);
    }

    public function testCss(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testJs(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testJs_admin(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testCss_admin(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
