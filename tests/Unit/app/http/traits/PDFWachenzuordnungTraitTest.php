<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PDFWachenzuordnungTrait;
use Tests\TestCase;

/**
 * Class PDFWachenzuordnungTraitTest.
 *
 * @covers \App\Http\Traits\PDFWachenzuordnungTrait
 */
final class PDFWachenzuordnungTraitTest extends TestCase
{
    private PDFWachenzuordnungTrait $pDFWachenzuordnungTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pDFWachenzuordnungTrait = $this->getMockBuilder(PDFWachenzuordnungTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pDFWachenzuordnungTrait);
    }

    public function testGetPdf(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
