<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\FxToolsFilesTrait;
use Tests\TestCase;

/**
 * Class FxToolsFilesTraitTest.
 *
 * @covers \App\Http\Traits\FxToolsFilesTrait
 */
final class FxToolsFilesTraitTest extends TestCase
{
    private FxToolsFilesTrait $fxToolsFilesTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->fxToolsFilesTrait = $this->getMockBuilder(FxToolsFilesTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fxToolsFilesTrait);
    }

    public function testGetPublicFilePath(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetFilesize(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetFileUploadMaxSize(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCheck_file_delete(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetfiletype(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testFileicon(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeFolderName(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetFileHeaderType(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testFile_upload_max_size(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testParse_size(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMaximumFileUploadSize(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testConvertPHPSizeToBytes(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
