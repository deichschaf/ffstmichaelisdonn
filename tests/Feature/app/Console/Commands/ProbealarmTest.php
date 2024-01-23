<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\Probealarm;
use Tests\TestCase;

/**
 * Class ProbealarmTest.
 *
 * @covers \App\Console\Commands\Probealarm
 */
final class ProbealarmTest extends TestCase
{
    private Probealarm $probealarm;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->probealarm = new Probealarm();
        $this->app->instance(Probealarm::class, $this->probealarm);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->probealarm);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('probealarm:senden')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
