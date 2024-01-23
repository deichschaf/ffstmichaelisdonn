<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PDFFunkrufnamenGemeindenTrait;
use Tests\TestCase;

/**
 * Class PDFFunkrufnamenGemeindenTraitTest.
 *
 * @covers \App\Http\Traits\PDFFunkrufnamenGemeindenTrait
 */
final class PDFFunkrufnamenGemeindenTraitTest extends TestCase
{
    private PDFFunkrufnamenGemeindenTrait $pDFFunkrufnamenGemeindenTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pDFFunkrufnamenGemeindenTrait = $this->getMockBuilder(PDFFunkrufnamenGemeindenTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pDFFunkrufnamenGemeindenTrait);
    }

    public function testGetConfig(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPdf(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
