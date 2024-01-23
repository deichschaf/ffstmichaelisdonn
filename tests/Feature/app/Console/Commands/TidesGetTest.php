<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\TidesGet;
use Tests\TestCase;

/**
 * Class TidesGetTest.
 *
 * @covers \App\Console\Commands\TidesGet
 */
final class TidesGetTest extends TestCase
{
    private TidesGet $tidesGet;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->tidesGet = new TidesGet();
        $this->app->instance(TidesGet::class, $this->tidesGet);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->tidesGet);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('tides:get')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
