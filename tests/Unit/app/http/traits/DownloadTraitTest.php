<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\DownloadTrait;
use Tests\TestCase;

/**
 * Class DownloadTraitTest.
 *
 * @covers \App\Http\Traits\DownloadTrait
 */
final class DownloadTraitTest extends TestCase
{
    private DownloadTrait $downloadTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->downloadTrait = $this->getMockBuilder(DownloadTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->downloadTrait);
    }

    public function testGetDownloads(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetDownloadKategorien(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetDownload(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
