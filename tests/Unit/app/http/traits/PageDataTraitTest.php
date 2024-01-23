<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PageDataTrait;
use Tests\TestCase;

/**
 * Class PageDataTraitTest.
 *
 * @covers \App\Http\Traits\PageDataTrait
 */
final class PageDataTraitTest extends TestCase
{
    private PageDataTrait $pageDataTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pageDataTrait = $this->getMockBuilder(PageDataTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pageDataTrait);
    }

    public function testCleanPageData(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
