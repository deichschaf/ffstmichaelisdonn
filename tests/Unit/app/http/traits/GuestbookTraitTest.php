<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\GuestbookTrait;
use Tests\TestCase;

/**
 * Class GuestbookTraitTest.
 *
 * @covers \App\Http\Traits\GuestbookTrait
 */
final class GuestbookTraitTest extends TestCase
{
    private GuestbookTrait $guestbookTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->guestbookTrait = $this->getMockBuilder(GuestbookTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->guestbookTrait);
    }

    public function testGuestbook_show(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdd(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testEdit(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSave(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testActive_by_mail(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testAdminShow(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
