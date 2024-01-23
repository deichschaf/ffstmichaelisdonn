<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ContactController;
use Tests\TestCase;

/**
 * Class ContactControllerTest.
 *
 * @covers \App\Http\Controllers\ContactController
 */
final class ContactControllerTest extends TestCase
{
    private ContactController $contactController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->contactController = new ContactController();
        $this->app->instance(ContactController::class, $this->contactController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->contactController);
    }

    public function testContact(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testContact_send(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
