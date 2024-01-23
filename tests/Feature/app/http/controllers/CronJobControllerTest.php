<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\CronJobController;
use Tests\TestCase;

/**
 * Class CronJobControllerTest.
 *
 * @covers \App\Http\Controllers\CronJobController
 */
final class CronJobControllerTest extends TestCase
{
    private CronJobController $cronJobController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->cronJobController = new CronJobController();
        $this->app->instance(CronJobController::class, $this->cronJobController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->cronJobController);
    }

    public function testCron(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testCron_birthday(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testCron_deltemp(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
