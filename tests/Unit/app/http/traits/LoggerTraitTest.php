<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\LoggerTrait;
use Tests\TestCase;

/**
 * Class LoggerTraitTest.
 *
 * @covers \App\Http\Traits\LoggerTrait
 */
final class LoggerTraitTest extends TestCase
{
    private LoggerTrait $loggerTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->loggerTrait = $this->getMockBuilder(LoggerTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->loggerTrait);
    }

    public function testMakeJsonLogging(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeLogInfo(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeLogError(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
