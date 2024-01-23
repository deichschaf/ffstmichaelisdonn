<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FxToolsStatusTrait;
use Tests\TestCase;

/**
 * Class FxToolsStatusTraitTest.
 *
 * @covers \App\Http\Traits\FxToolsStatusTrait
 */
final class FxToolsStatusTraitTest extends TestCase
{
    private FxToolsStatusTrait $fxToolsStatusTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->fxToolsStatusTrait = $this->getMockBuilder(FxToolsStatusTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fxToolsStatusTrait);
    }

    public function testGetHttpStatus(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetIUploadError(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
