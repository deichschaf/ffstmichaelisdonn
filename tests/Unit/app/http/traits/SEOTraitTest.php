<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\SEOTrait;
use Tests\TestCase;

/**
 * Class SEOTraitTest.
 *
 * @covers \App\Http\Traits\SEOTrait
 */
final class SEOTraitTest extends TestCase
{
    private SEOTrait $sEOTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->sEOTrait = $this->getMockBuilder(SEOTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->sEOTrait);
    }

    public function testSEOUrl(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSaveSEOUrl(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testWriteAutoRoute(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
