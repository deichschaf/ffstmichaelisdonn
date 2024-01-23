<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\DWDMaps;
use Tests\TestCase;

/**
 * Class DWDMapsTest.
 *
 * @covers \App\Console\Commands\DWDMaps
 */
final class DWDMapsTest extends TestCase
{
    private DWDMaps $dWDMaps;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dWDMaps = new DWDMaps();
        $this->app->instance(DWDMaps::class, $this->dWDMaps);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dWDMaps);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('dwd:maps')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
