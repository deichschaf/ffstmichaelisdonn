<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\CalendarTrait;
use Tests\TestCase;

/**
 * Class CalendarTraitTest.
 *
 * @covers \App\Http\Traits\CalendarTrait
 */
final class CalendarTraitTest extends TestCase
{
    private CalendarTrait $calendarTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->calendarTrait = $this->getMockBuilder(CalendarTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->calendarTrait);
    }

    public function testMakeCalendar(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
