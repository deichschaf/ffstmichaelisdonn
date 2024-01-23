<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\MinifyController;
use Tests\TestCase;

/**
 * Class MinifyControllerTest.
 *
 * @covers \App\Http\Controllers\MinifyController
 */
final class MinifyControllerTest extends TestCase
{
    private MinifyController $minifyController;

    private array $options;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->options = [];
        $this->minifyController = new MinifyController($this->options);
        $this->app->instance(MinifyController::class, $this->minifyController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->minifyController);
        unset($this->options);
    }

    public function testMinify(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
