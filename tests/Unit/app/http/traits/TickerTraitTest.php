<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\TickerTrait;
use Tests\TestCase;

/**
 * Class TickerTraitTest.
 *
 * @covers \App\Http\Traits\TickerTrait
 */
final class TickerTraitTest extends TestCase
{
    private TickerTrait $tickerTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->tickerTrait = $this->getMockBuilder(TickerTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->tickerTrait);
    }

    public function testShowTicker(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
