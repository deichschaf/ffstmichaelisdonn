<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\CriticalreaderNina;
use Tests\TestCase;

/**
 * Class CriticalreaderNinaTest.
 *
 * @covers \App\Console\Commands\CriticalreaderNina
 */
final class CriticalreaderNinaTest extends TestCase
{
    private CriticalreaderNina $criticalreaderNina;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->criticalreaderNina = new CriticalreaderNina();
        $this->app->instance(CriticalreaderNina::class, $this->criticalreaderNina);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->criticalreaderNina);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('criticalreader:nina')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
