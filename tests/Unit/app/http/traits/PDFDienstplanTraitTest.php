<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PDFDienstplanTrait;
use Tests\TestCase;

/**
 * Class PDFDienstplanTraitTest.
 *
 * @covers \App\Http\Traits\PDFDienstplanTrait
 */
final class PDFDienstplanTraitTest extends TestCase
{
    private PDFDienstplanTrait $pDFDienstplanTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pDFDienstplanTrait = $this->getMockBuilder(PDFDienstplanTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pDFDienstplanTrait);
    }

    public function testGetPdf(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
