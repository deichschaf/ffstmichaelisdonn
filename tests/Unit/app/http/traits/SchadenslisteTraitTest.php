<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\SchadenslisteTrait;
use Tests\TestCase;

/**
 * Class SchadenslisteTraitTest.
 *
 * @covers \App\Http\Traits\SchadenslisteTrait
 */
final class SchadenslisteTraitTest extends TestCase
{
    private SchadenslisteTrait $schadenslisteTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->schadenslisteTrait = $this->getMockBuilder(SchadenslisteTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->schadenslisteTrait);
    }

    public function testGsa(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testEg(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testEmk(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testEw(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRettungsdienst(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSaveSchaden(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetSchaden(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetTELBegriffe(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
