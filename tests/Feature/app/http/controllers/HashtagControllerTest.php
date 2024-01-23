<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\HashtagController;
use Tests\TestCase;

/**
 * Class HashtagControllerTest.
 *
 * @covers \App\Http\Controllers\HashtagController
 */
final class HashtagControllerTest extends TestCase
{
    private HashtagController $hashtagController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->hashtagController = new HashtagController();
        $this->app->instance(HashtagController::class, $this->hashtagController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->hashtagController);
    }

    public function testMakeHashtag(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testBuild_hashtag(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAddHashtag(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
