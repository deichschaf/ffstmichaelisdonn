<?php

namespace Tests\Unit\Http\Traits;

use App\Http\Traits\SocialMediaTrait;
use Tests\TestCase;

/**
 * Class SocialMediaTraitTest.
 *
 * @covers \App\Http\Traits\SocialMediaTrait
 */
final class SocialMediaTraitTest extends TestCase
{
    private SocialMediaTrait $socialMediaTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->socialMediaTrait = $this->getMockBuilder(SocialMediaTrait::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->socialMediaTrait);
    }

    public function testGetFacebookDescription(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
