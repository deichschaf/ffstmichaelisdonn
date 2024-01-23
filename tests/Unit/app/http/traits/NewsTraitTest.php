<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\NewsTrait;
use Tests\TestCase;

/**
 * Class NewsTraitTest.
 *
 * @covers \App\Http\Traits\NewsTrait
 */
final class NewsTraitTest extends TestCase
{
    private NewsTrait $newsTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->newsTrait = $this->getMockBuilder(NewsTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->newsTrait);
    }

    public function testNews_show(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testNews_show_trait(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetShortText(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetNews(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetPresseInfo(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLastNews(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
