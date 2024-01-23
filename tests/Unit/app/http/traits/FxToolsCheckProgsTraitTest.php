<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FxToolsCheckProgsTrait;
use Tests\TestCase;

/**
 * Class FxToolsCheckProgsTraitTest.
 *
 * @covers \App\Http\Traits\FxToolsCheckProgsTrait
 */
final class FxToolsCheckProgsTraitTest extends TestCase
{
    private FxToolsCheckProgsTrait $fxToolsCheckProgsTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->fxToolsCheckProgsTrait = $this->getMockBuilder(FxToolsCheckProgsTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fxToolsCheckProgsTrait);
    }

    public function testCheckImageMagick(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCheckServerVersion(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
