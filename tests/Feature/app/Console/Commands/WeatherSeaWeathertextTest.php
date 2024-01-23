<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\WeatherSeaWeathertext;
use Tests\TestCase;

/**
 * Class WeatherSeaWeathertextTest.
 *
 * @covers \App\Console\Commands\WeatherSeaWeathertext
 */
final class WeatherSeaWeathertextTest extends TestCase
{
    private WeatherSeaWeathertext $weatherSeaWeathertext;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->weatherSeaWeathertext = new WeatherSeaWeathertext();
        $this->app->instance(WeatherSeaWeathertext::class, $this->weatherSeaWeathertext);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->weatherSeaWeathertext);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('weather:seaweathertext')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
