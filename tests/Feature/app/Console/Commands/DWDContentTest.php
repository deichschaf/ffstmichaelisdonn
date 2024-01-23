<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\DWDContent;
use Tests\TestCase;

/**
 * Class DWDContentTest.
 *
 * @covers \App\Console\Commands\DWDContent
 */
final class DWDContentTest extends TestCase
{
    private DWDContent $dWDContent;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dWDContent = new DWDContent();
        $this->app->instance(DWDContent::class, $this->dWDContent);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dWDContent);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('dwd:content')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
