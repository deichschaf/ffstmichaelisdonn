<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\SearchHashtag;
use Tests\TestCase;

/**
 * Class SearchHashtagTest.
 *
 * @covers \App\Http\Controllers\SearchHashtag
 */
final class SearchHashtagTest extends TestCase
{
    private SearchHashtag $searchHashtag;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->searchHashtag = new SearchHashtag();
        $this->app->instance(SearchHashtag::class, $this->searchHashtag);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->searchHashtag);
    }

    public function testSearch(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
