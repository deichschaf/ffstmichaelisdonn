<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PDFFunkrufnamenTrait;
use Tests\TestCase;

/**
 * Class PDFFunkrufnamenTraitTest.
 *
 * @covers \App\Http\Traits\PDFFunkrufnamenTrait
 */
final class PDFFunkrufnamenTraitTest extends TestCase
{
    private PDFFunkrufnamenTrait $pDFFunkrufnamenTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pDFFunkrufnamenTrait = $this->getMockBuilder(PDFFunkrufnamenTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pDFFunkrufnamenTrait);
    }

    public function testGetPdf(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
