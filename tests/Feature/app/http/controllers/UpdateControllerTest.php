<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UpdateController;
use Tests\TestCase;

/**
 * Class UpdateControllerTest.
 *
 * @covers \App\Http\Controllers\UpdateController
 */
final class UpdateControllerTest extends TestCase
{
    private UpdateController $updateController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->updateController = new UpdateController();
        $this->app->instance(UpdateController::class, $this->updateController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->updateController);
    }

    public function testUpdate(): void
    {
        /** @todo This test is incomplete. */
        $this->put('/path', [ /* data */ ])
            ->assertStatus(200);
    }
}
