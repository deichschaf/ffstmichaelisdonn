<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\TodoTrait;
use Tests\TestCase;

/**
 * Class TodoTraitTest.
 *
 * @covers \App\Http\Traits\TodoTrait
 */
final class TodoTraitTest extends TestCase
{
    private TodoTrait $todoTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->todoTrait = $this->getMockBuilder(TodoTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->todoTrait);
    }

    public function testGetToDoStatistic(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLastOpenToDoStatistic(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSetToDoStore(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
