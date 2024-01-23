<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\ReadFirecardSpecialOffers;
use Tests\TestCase;

/**
 * Class ReadFirecardSpecialOffersTest.
 *
 * @covers \App\Console\Commands\ReadFirecardSpecialOffers
 */
final class ReadFirecardSpecialOffersTest extends TestCase
{
    private ReadFirecardSpecialOffers $readFirecardSpecialOffers;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->readFirecardSpecialOffers = new ReadFirecardSpecialOffers();
        $this->app->instance(ReadFirecardSpecialOffers::class, $this->readFirecardSpecialOffers);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->readFirecardSpecialOffers);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('firecard:offers')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }

    public function testReadUrls(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
