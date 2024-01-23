<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\InternTrait;
use Tests\TestCase;

/**
 * Class InternTraitTest.
 *
 * @covers \App\Http\Traits\InternTrait
 */
final class InternTraitTest extends TestCase
{
    private InternTrait $internTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->internTrait = $this->getMockBuilder(InternTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->internTrait);
    }

    public function testGetInternDownload(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
