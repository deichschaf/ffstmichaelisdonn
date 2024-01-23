<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\ContactTrait;
use Tests\TestCase;

/**
 * Class ContactTraitTest.
 *
 * @covers \App\Http\Traits\ContactTrait
 */
final class ContactTraitTest extends TestCase
{
    private ContactTrait $contactTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->contactTrait = $this->getMockBuilder(ContactTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->contactTrait);
    }

    public function testSaveContactForm(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
