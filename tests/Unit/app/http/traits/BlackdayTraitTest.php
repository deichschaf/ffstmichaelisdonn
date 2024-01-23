<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\BlackdayTrait;
use Tests\TestCase;

/**
 * Class BlackdayTraitTest.
 *
 * @covers \App\Http\Traits\BlackdayTrait
 */
final class BlackdayTraitTest extends TestCase
{
    private BlackdayTrait $blackdayTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->blackdayTrait = $this->getMockBuilder(BlackdayTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->blackdayTrait);
    }

    public function testGetIsBlackday(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetBlackdayContent(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
