<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ImageController;
use Tests\TestCase;

/**
 * Class ImageControllerTest.
 *
 * @covers \App\Http\Controllers\ImageController
 */
final class ImageControllerTest extends TestCase
{
    private ImageController $imageController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->imageController = new ImageController();
        $this->app->instance(ImageController::class, $this->imageController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->imageController);
    }

    public function testThumb_150(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testThumbnails(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
