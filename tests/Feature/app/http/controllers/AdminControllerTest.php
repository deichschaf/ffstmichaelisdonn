<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\AdminController;
use Tests\TestCase;

/**
 * Class AdminControllerTest.
 *
 * @covers \App\Http\Controllers\AdminController
 */
final class AdminControllerTest extends TestCase
{
    private AdminController $adminController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->adminController = new AdminController();
        $this->app->instance(AdminController::class, $this->adminController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->adminController);
    }

    public function testAcpLogin(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAcpLogout(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testCheckAcpRights(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
