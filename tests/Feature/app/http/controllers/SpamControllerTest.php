<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\SpamController;
use Tests\TestCase;

/**
 * Class SpamControllerTest.
 *
 * @covers \App\Http\Controllers\SpamController
 */
final class SpamControllerTest extends TestCase
{
    private SpamController $spamController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->spamController = new SpamController();
        $this->app->instance(SpamController::class, $this->spamController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->spamController);
    }

    public function testGetSpam(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
