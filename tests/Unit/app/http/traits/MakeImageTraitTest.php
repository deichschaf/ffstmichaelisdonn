<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\MakeImageTrait;
use Tests\TestCase;

/**
 * Class MakeImageTraitTest.
 *
 * @covers \App\Http\Traits\MakeImageTrait
 */
final class MakeImageTraitTest extends TestCase
{
    private MakeImageTrait $makeImageTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->makeImageTrait = $this->getMockBuilder(MakeImageTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->makeImageTrait);
    }

    public function testMakeImage(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCorrectPath(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
