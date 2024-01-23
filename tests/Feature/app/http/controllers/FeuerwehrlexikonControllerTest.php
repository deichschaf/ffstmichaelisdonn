<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FeuerwehrlexikonController;
use Tests\TestCase;

/**
 * Class FeuerwehrlexikonControllerTest.
 *
 * @covers \App\Http\Controllers\FeuerwehrlexikonController
 */
final class FeuerwehrlexikonControllerTest extends TestCase
{
    private FeuerwehrlexikonController $feuerwehrlexikonController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->feuerwehrlexikonController = new FeuerwehrlexikonController();
        $this->app->instance(FeuerwehrlexikonController::class, $this->feuerwehrlexikonController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->feuerwehrlexikonController);
    }

    public function testLexikon_show(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
