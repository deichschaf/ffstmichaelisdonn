<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PDFMitgliederTrait;
use Tests\TestCase;

/**
 * Class PDFMitgliederTraitTest.
 *
 * @covers \App\Http\Traits\PDFMitgliederTrait
 */
final class PDFMitgliederTraitTest extends TestCase
{
    private PDFMitgliederTrait $pDFMitgliederTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pDFMitgliederTrait = $this->getMockBuilder(PDFMitgliederTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pDFMitgliederTrait);
    }

    public function testGetPdf(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
