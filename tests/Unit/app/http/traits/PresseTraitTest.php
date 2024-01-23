<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\PresseTrait;
use Tests\TestCase;

/**
 * Class PresseTraitTest.
 *
 * @covers \App\Http\Traits\PresseTrait
 */
final class PresseTraitTest extends TestCase
{
    private PresseTrait $presseTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->presseTrait = $this->getMockBuilder(PresseTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->presseTrait);
    }

    public function testNews_show(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdmin_news_show(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPresse(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPresseInfo(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLastPresse(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
