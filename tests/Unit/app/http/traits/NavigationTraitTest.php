<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\NavigationTrait;
use Tests\TestCase;

/**
 * Class NavigationTraitTest.
 *
 * @covers \App\Http\Traits\NavigationTrait
 */
final class NavigationTraitTest extends TestCase
{
    private NavigationTrait $navigationTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->navigationTrait = $this->getMockBuilder(NavigationTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->navigationTrait);
    }

    public function testGetAktivPage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSetActivePage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetAktivTop(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetTopNavi(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMainNavi(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetFooterNavi(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLeftNavi3(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMobileNavi(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
