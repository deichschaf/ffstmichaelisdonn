<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\Diff;
use Tests\TestCase;

/**
 * Class DiffTest.
 *
 * @covers \App\Http\Controllers\Diff
 */
final class DiffTest extends TestCase
{
    private Diff $diff;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->diff = new Diff();
        $this->app->instance(Diff::class, $this->diff);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->diff);
    }

    public function testDiff(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testHtmlDiff(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testDiff_Check(): void
    {
        /** @todo This test is incomplete. */
        $this->get('/path')
            ->assertStatus(200);
    }
}
