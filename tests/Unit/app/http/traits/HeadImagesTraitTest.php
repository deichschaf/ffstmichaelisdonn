<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\HeadImagesTrait;
use Tests\TestCase;

/**
 * Class HeadImagesTraitTest.
 *
 * @covers \App\Http\Traits\HeadImagesTrait
 */
final class HeadImagesTraitTest extends TestCase
{
    private HeadImagesTrait $headImagesTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->headImagesTrait = $this->getMockBuilder(HeadImagesTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->headImagesTrait);
    }

    public function testShow(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminShow(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminAdd(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminEdit(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminDelete(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminDeletePost(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminSavet(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
