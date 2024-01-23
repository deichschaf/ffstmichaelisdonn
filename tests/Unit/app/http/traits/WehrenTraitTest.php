<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\WehrenTrait;
use Tests\TestCase;

/**
 * Class WehrenTraitTest.
 *
 * @covers \App\Http\Traits\WehrenTrait
 */
final class WehrenTraitTest extends TestCase
{
    private WehrenTrait $wehrenTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->wehrenTrait = $this->getMockBuilder(WehrenTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->wehrenTrait);
    }

    public function testGetAll(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetData(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDelete(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
