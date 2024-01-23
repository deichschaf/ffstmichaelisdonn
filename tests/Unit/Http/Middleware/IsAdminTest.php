<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\IsAdmin;
use Tests\TestCase;

/**
 * Class IsAdminTest.
 *
 * @covers \App\Http\Middleware\IsAdmin
 */
final class IsAdminTest extends TestCase
{
    private IsAdmin $isAdmin;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->isAdmin = new IsAdmin();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->isAdmin);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
