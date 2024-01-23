<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\NewsletterTrait;
use Tests\TestCase;

/**
 * Class NewsletterTraitTest.
 *
 * @covers \App\Http\Traits\NewsletterTrait
 */
final class NewsletterTraitTest extends TestCase
{
    private NewsletterTrait $newsletterTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->newsletterTrait = $this->getMockBuilder(NewsletterTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->newsletterTrait);
    }

    public function testGetAllNewsletter(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
