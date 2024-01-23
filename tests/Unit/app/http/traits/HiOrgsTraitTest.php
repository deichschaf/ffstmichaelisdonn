<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\HiOrgsTrait;
use Tests\TestCase;

/**
 * Class HiOrgsTraitTest.
 *
 * @covers \App\Http\Traits\HiOrgsTrait
 */
final class HiOrgsTraitTest extends TestCase
{
    private HiOrgsTrait $hiOrgsTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->hiOrgsTrait = $this->getMockBuilder(HiOrgsTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->hiOrgsTrait);
    }

    public function testGetHiOrgsSmall(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetHiOrgs(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
