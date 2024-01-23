<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\CriticalreaderNewSender;
use Tests\TestCase;

/**
 * Class CriticalreaderNewSenderTest.
 *
 * @covers \App\Console\Commands\CriticalreaderNewSender
 */
final class CriticalreaderNewSenderTest extends TestCase
{
    private CriticalreaderNewSender $criticalreaderNewSender;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->criticalreaderNewSender = new CriticalreaderNewSender();
        $this->app->instance(CriticalreaderNewSender::class, $this->criticalreaderNewSender);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->criticalreaderNewSender);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('criticalreader:newsender')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
