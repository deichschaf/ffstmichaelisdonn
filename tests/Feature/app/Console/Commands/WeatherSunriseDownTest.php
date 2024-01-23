<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\WeatherSunriseDown;
use Tests\TestCase;

/**
 * Class WeatherSunriseDownTest.
 *
 * @covers \App\Console\Commands\WeatherSunriseDown
 */
final class WeatherSunriseDownTest extends TestCase
{
    private WeatherSunriseDown $weatherSunriseDown;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->weatherSunriseDown = new WeatherSunriseDown();
        $this->app->instance(WeatherSunriseDown::class, $this->weatherSunriseDown);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->weatherSunriseDown);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('weather:sunrisedown')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
