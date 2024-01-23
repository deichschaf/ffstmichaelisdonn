<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\WeatherWeathertext;
use Tests\TestCase;

/**
 * Class WeatherWeathertextTest.
 *
 * @covers \App\Console\Commands\WeatherWeathertext
 */
final class WeatherWeathertextTest extends TestCase
{
    private WeatherWeathertext $weatherWeathertext;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->weatherWeathertext = new WeatherWeathertext();
        $this->app->instance(WeatherWeathertext::class, $this->weatherWeathertext);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->weatherWeathertext);
    }

    public function testHandle(): void
    {
        /** @todo This test is incomplete. */
        $this->artisan('weather:weathertext')
            ->expectsOutput('Some expected output')
            ->assertExitCode(0);
    }
}
