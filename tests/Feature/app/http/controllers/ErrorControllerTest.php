<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ErrorController;
use Tests\TestCase;

/**
 * Class ErrorControllerTest.
 *
 * @covers \App\Http\Controllers\ErrorController
 */
final class ErrorControllerTest extends TestCase
{
    private ErrorController $errorController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->errorController = new ErrorController();
        $this->app->instance(ErrorController::class, $this->errorController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->errorController);
    }

    public function testError_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
