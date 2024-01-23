<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\DWDRadar;
use Tests\TestCase;

/**
 * Class DWDRadarTest.
 *
 * @covers \App\Console\Commands\DWDRadar
 */
final class DWDRadarTest extends TestCase
{
    private DWDRadar $dWDRadar;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dWDRadar = new DWDRadar();
        $this->app->instance(DWDRadar::class, $this->dWDRadar);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dWDRadar);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('dwd:radar')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
