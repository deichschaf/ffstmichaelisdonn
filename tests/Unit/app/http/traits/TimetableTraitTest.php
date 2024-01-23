<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\TimetableTrait;
use Tests\TestCase;

/**
 * Class TimetableTraitTest.
 *
 * @covers \App\Http\Traits\TimetableTrait
 */
final class TimetableTraitTest extends TestCase
{
    private TimetableTrait $timetableTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->timetableTrait = $this->getMockBuilder(TimetableTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->timetableTrait);
    }

    public function testGetDays(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetDayIds(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testBuildTimeTable(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
