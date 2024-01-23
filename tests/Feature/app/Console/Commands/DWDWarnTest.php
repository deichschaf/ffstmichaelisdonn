<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\DWDWarn;
use Tests\TestCase;

/**
 * Class DWDWarnTest.
 *
 * @covers \App\Console\Commands\DWDWarn
 */
final class DWDWarnTest extends TestCase
{
    private DWDWarn $dWDWarn;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dWDWarn = new DWDWarn();
        $this->app->instance(DWDWarn::class, $this->dWDWarn);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dWDWarn);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('dwd:warn')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
