<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FxToolsSimpleBBCodeTrait;
use Tests\TestCase;

/**
 * Class FxToolsSimpleBBCodeTraitTest.
 *
 * @covers \App\Http\Traits\FxToolsSimpleBBCodeTrait
 */
final class FxToolsSimpleBBCodeTraitTest extends TestCase
{
    private FxToolsSimpleBBCodeTrait $fxToolsSimpleBBCodeTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->fxToolsSimpleBBCodeTrait = $this->getMockBuilder(FxToolsSimpleBBCodeTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fxToolsSimpleBBCodeTrait);
    }

    public function testParse(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAssign(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testHandleYoutubeBBcode(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testHandleListBBcode(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
