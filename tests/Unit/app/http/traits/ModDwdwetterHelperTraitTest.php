<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\ModDwdwetterHelperTrait;
use Tests\TestCase;

/**
 * Class ModDwdwetterHelperTraitTest.
 *
 * @covers \App\Http\Traits\ModDwdwetterHelperTrait
 */
final class ModDwdwetterHelperTraitTest extends TestCase
{
    private ModDwdwetterHelperTrait $modDwdwetterHelperTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->modDwdwetterHelperTrait = $this->getMockBuilder(ModDwdwetterHelperTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->modDwdwetterHelperTrait);
    }

    public function testGetBftfromWind(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMondPhase(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetDWDFTP(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMoon(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetList(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testKatAlarm(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDWDWarn(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCronDWDWarn(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testApiGetSunRiseDown(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAddNewCriticalSender(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCriticalSender(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testReadCriticalGermany(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetDWDRadar(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetWeatherText(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetSeaWeatherText(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetWeatherMaps(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCronGetTides(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetTides(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
