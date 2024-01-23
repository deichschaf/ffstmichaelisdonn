<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\LinksTrait;
use Tests\TestCase;

/**
 * Class LinksTraitTest.
 *
 * @covers \App\Http\Traits\LinksTrait
 */
final class LinksTraitTest extends TestCase
{
    private LinksTrait $linksTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->linksTrait = $this->getMockBuilder(LinksTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->linksTrait);
    }

    public function testGetLinks(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLinksKategorien(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
