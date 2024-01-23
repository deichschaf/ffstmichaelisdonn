<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\ReadFaxMail;
use Tests\TestCase;

/**
 * Class ReadFaxMailTest.
 *
 * @covers \App\Console\Commands\ReadFaxMail
 */
final class ReadFaxMailTest extends TestCase
{
    private ReadFaxMail $readFaxMail;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->readFaxMail = new ReadFaxMail();
        $this->app->instance(ReadFaxMail::class, $this->readFaxMail);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->readFaxMail);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('alarm:reademail')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
