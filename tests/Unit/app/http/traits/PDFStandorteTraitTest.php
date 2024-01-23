<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PDFStandorteTrait;
use Tests\TestCase;

/**
 * Class PDFStandorteTraitTest.
 *
 * @covers \App\Http\Traits\PDFStandorteTrait
 */
final class PDFStandorteTraitTest extends TestCase
{
    private PDFStandorteTrait $pDFStandorteTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->pDFStandorteTrait = $this->getMockBuilder(PDFStandorteTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->pDFStandorteTrait);
    }

    public function testGetPdf(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
