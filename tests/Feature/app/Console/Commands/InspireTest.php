<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\Inspire;
use Tests\TestCase;

/**
 * Class InspireTest.
 *
 * @covers \App\Console\Commands\Inspire
 */
final class InspireTest extends TestCase
{
    private Inspire $inspire;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->inspire = new Inspire();
        $this->app->instance(Inspire::class, $this->inspire);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->inspire);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('inspire')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
