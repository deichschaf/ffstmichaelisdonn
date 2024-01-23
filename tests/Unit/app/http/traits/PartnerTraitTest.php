<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PartnerTrait;
use Tests\TestCase;

/**
 * Class PartnerTraitTest.
 *
 * @covers \App\Http\Traits\PartnerTrait
 */
final class PartnerTraitTest extends TestCase
{
    private PartnerTrait $partnerTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->partnerTrait = $this->getMockBuilder(PartnerTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->partnerTrait);
    }

    public function testShowPartner(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
