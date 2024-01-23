<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FxToolsUrlTrait;
use Tests\TestCase;

/**
 * Class FxToolsUrlTraitTest.
 *
 * @covers \App\Http\Traits\FxToolsUrlTrait
 */
final class FxToolsUrlTraitTest extends TestCase
{
    private FxToolsUrlTrait $fxToolsUrlTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->fxToolsUrlTrait = $this->getMockBuilder(FxToolsUrlTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fxToolsUrlTrait);
    }

    public function testCheckLink(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeLink(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
