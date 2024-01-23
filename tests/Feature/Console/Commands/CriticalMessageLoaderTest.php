<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\CriticalMessageLoader;
use Tests\TestCase;

/**
 * Class CriticalMessageLoaderTest.
 *
 * @covers \App\Console\Commands\CriticalMessageLoader
 */
final class CriticalMessageLoaderTest extends TestCase
{
    private CriticalMessageLoader $criticalMessageLoader;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->criticalMessageLoader = new CriticalMessageLoader();
        $this->app->instance(CriticalMessageLoader::class, $this->criticalMessageLoader);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->criticalMessageLoader);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('command:name')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
