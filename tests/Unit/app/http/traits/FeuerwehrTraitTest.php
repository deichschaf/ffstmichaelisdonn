<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FeuerwehrTrait;
use Tests\TestCase;

/**
 * Class FeuerwehrTraitTest.
 *
 * @covers \App\Http\Traits\FeuerwehrTrait
 */
final class FeuerwehrTraitTest extends TestCase
{
    private FeuerwehrTrait $feuerwehrTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->feuerwehrTrait = $this->getMockBuilder(FeuerwehrTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->feuerwehrTrait);
    }

    public function testGetFireDepartmentStatistic(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testShow_job(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDienstgradeKombinationen(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDienstgrade(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDienstgradeAbzeichen(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDiestgradVorraussetzungen(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDiestgradVorraussetzungenKuerzel(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testShow_flyer(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSend_fire_contactform(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
