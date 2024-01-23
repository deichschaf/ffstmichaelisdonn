<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\MusikzugTrait;
use Tests\TestCase;

/**
 * Class MusikzugTraitTest.
 *
 * @covers \App\Http\Traits\MusikzugTrait
 */
final class MusikzugTraitTest extends TestCase
{
    private MusikzugTrait $musikzugTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->musikzugTrait = $this->getMockBuilder(MusikzugTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->musikzugTrait);
    }

    public function testGetMusikzugFuehrung(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMusizugMitglieder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetMusizugEhrenMitglieder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
