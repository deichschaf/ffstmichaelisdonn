<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FirecardController;
use Tests\TestCase;

/**
 * Class FirecardControllerTest.
 *
 * @covers \App\Http\Controllers\FirecardController
 */
final class FirecardControllerTest extends TestCase
{
    private FirecardController $firecardController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->firecardController = new FirecardController();
        $this->app->instance(FirecardController::class, $this->firecardController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->firecardController);
    }

    public function testOverview(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdmin_overview(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminAdd(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminEdit(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminDelete(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminDeletePost(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminSave(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
