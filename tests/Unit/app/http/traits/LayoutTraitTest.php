<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\LayoutTrait;
use Tests\TestCase;

/**
 * Class LayoutTraitTest.
 *
 * @covers \App\Http\Traits\LayoutTrait
 */
final class LayoutTraitTest extends TestCase
{
    private LayoutTrait $layoutTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->layoutTrait = $this->getMockBuilder(LayoutTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->layoutTrait);
    }

    public function testLayout_content(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testLayout_content_error(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testReplacePlaceholderOneName(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testPageContentTypes(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
