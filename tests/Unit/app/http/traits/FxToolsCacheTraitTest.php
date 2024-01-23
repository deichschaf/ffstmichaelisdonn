<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FxToolsCacheTrait;
use Tests\TestCase;

/**
 * Class FxToolsCacheTraitTest.
 *
 * @covers \App\Http\Traits\FxToolsCacheTrait
 */
final class FxToolsCacheTraitTest extends TestCase
{
    private FxToolsCacheTrait $fxToolsCacheTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->fxToolsCacheTrait = $this->getMockBuilder(FxToolsCacheTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fxToolsCacheTrait);
    }

    public function testCreateCache(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetCache(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testOpenCache(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testWriteCache(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDeleteCache(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
