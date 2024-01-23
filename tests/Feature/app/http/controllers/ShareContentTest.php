<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ShareContent;
use Tests\TestCase;

/**
 * Class ShareContentTest.
 *
 * @covers \App\Http\Controllers\ShareContent
 */
final class ShareContentTest extends TestCase
{
    private ShareContent $shareContent;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->shareContent = new ShareContent();
        $this->app->instance(ShareContent::class, $this->shareContent);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->shareContent);
    }

    public function testShareFacebook(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShareTwitter(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShareFlickr(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShareGooglePlus(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShareYouTube(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testShareInstagram(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
