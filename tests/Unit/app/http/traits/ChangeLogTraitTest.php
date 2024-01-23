<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\ChangeLogTrait;
use Tests\TestCase;

/**
 * Class ChangeLogTraitTest.
 *
 * @covers \App\Http\Traits\ChangeLogTrait
 */
final class ChangeLogTraitTest extends TestCase
{
    private ChangeLogTrait $changeLogTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->changeLogTrait = $this->getMockBuilder(ChangeLogTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->changeLogTrait);
    }

    public function testGetListChangeLog(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLastChangeLogDetailsEdit(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetLastChangeLog(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSaveChangeLog(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
