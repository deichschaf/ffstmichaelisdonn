<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\MitgliederTrait;
use Tests\TestCase;

/**
 * Class MitgliederTraitTest.
 *
 * @covers \App\Http\Traits\MitgliederTrait
 */
final class MitgliederTraitTest extends TestCase
{
    private MitgliederTrait $mitgliederTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->mitgliederTrait = $this->getMockBuilder(MitgliederTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->mitgliederTrait);
    }

    public function testGetVorstand(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMitglieder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetVorstandMitgliedData(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMitgliedPositionen(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCheck_kontakt_exists(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPersonalDataByPosition(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMitgliederShort(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testExportMitglieder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
