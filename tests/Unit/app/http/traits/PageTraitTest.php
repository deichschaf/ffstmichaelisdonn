<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PageTrait;
use Tests\TestCase;

/**
 * Class PageTraitTest.
 *
 * @covers \App\Http\Traits\PageTrait
 */
final class PageTraitTest extends TestCase
{
    private PageTrait $pageTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pageTrait = $this->getMockBuilder(PageTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pageTrait);
    }

    public function testGetSearchPage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPages(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testReplacePlaceholder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPlaceholder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testreplaceTextPlaceholder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDelPage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSavePage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSavePageHeadline(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPageContentTypes(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
