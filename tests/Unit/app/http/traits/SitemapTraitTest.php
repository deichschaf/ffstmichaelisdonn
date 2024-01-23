<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\SitemapTrait;
use Tests\TestCase;

/**
 * Class SitemapTraitTest.
 *
 * @covers \App\Http\Traits\SitemapTrait
 */
final class SitemapTraitTest extends TestCase
{
    private SitemapTrait $sitemapTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->sitemapTrait = $this->getMockBuilder(SitemapTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->sitemapTrait);
    }

    public function testGetSitemapGenerator(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetSitemap(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetSitemapDetails(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetSitemapXml(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetSitemapXmlDetails(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
