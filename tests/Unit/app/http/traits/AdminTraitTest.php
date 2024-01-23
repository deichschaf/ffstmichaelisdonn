<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\AdminTrait;
use Tests\TestCase;

/**
 * Class AdminTraitTest.
 *
 * @covers \App\Http\Traits\AdminTrait
 */
final class AdminTraitTest extends TestCase
{
    private AdminTrait $adminTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->adminTrait = $this->getMockBuilder(AdminTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->adminTrait);
    }

    public function testMakeAcpLogin(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeAcpLogout(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeCheckAcpRights(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
