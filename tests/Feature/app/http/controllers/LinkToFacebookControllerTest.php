<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\LinkToFacebookController;
use Tests\TestCase;

/**
 * Class LinkToFacebookControllerTest.
 *
 * @covers \App\Http\Controllers\LinkToFacebookController
 */
final class LinkToFacebookControllerTest extends TestCase
{
    private LinkToFacebookController $linkToFacebookController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->linkToFacebookController = new LinkToFacebookController();
        $this->app->instance(LinkToFacebookController::class, $this->linkToFacebookController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->linkToFacebookController);
    }

    public function testFacebook_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
