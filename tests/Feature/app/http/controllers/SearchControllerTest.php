<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\SearchController;
use Tests\TestCase;

/**
 * Class SearchControllerTest.
 *
 * @covers \App\Http\Controllers\SearchController
 */
final class SearchControllerTest extends TestCase
{
    private SearchController $searchController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->searchController = new SearchController();
        $this->app->instance(SearchController::class, $this->searchController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->searchController);
    }

    public function testSearchShow(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testAutoresponse(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
