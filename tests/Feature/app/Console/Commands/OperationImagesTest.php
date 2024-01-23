<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\OperationImages;
use Tests\TestCase;

/**
 * Class OperationImagesTest.
 *
 * @covers \App\Console\Commands\OperationImages
 */
final class OperationImagesTest extends TestCase
{
    private OperationImages $operationImages;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->operationImages = new OperationImages();
        $this->app->instance(OperationImages::class, $this->operationImages);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->operationImages);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('operation:make')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
