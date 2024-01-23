<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\WidgetTrait;
use Tests\TestCase;

/**
 * Class WidgetTraitTest.
 *
 * @covers \App\Http\Traits\WidgetTrait
 */
final class WidgetTraitTest extends TestCase
{
    private WidgetTrait $widgetTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->widgetTrait = $this->getMockBuilder(WidgetTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->widgetTrait);
    }

    public function testGetWidgets(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetWidget(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetWidgetJob(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetWidgetFlyer(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
