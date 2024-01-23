<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\TelLexikonTrait;
use Tests\TestCase;

/**
 * Class TelLexikonTraitTest.
 *
 * @covers \App\Http\Traits\TelLexikonTrait
 */
final class TelLexikonTraitTest extends TestCase
{
    private TelLexikonTrait $telLexikonTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->telLexikonTrait = $this->getMockBuilder(TelLexikonTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->telLexikonTrait);
    }

    public function testSearch(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testTellexikon_show(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testShowSelect(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
