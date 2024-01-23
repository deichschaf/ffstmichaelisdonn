<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\HeaderTrait;
use Tests\TestCase;

/**
 * Class HeaderTraitTest.
 *
 * @covers \App\Http\Traits\HeaderTrait
 */
final class HeaderTraitTest extends TestCase
{
    private HeaderTrait $headerTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->headerTrait = $this->getMockBuilder(HeaderTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->headerTrait);
    }

    public function testGetHeader(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
