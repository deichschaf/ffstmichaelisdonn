<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\MetatagsController;
use Tests\TestCase;

/**
 * Class MetatagsControllerTest.
 *
 * @covers \App\Http\Controllers\MetatagsController
 */
final class MetatagsControllerTest extends TestCase
{
    private MetatagsController $metatagsController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->metatagsController = new MetatagsController();
        $this->app->instance(MetatagsController::class, $this->metatagsController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->metatagsController);
    }

    public function testGetMetatags(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAdminShow(): void
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
