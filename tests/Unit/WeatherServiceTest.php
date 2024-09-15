<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Http;

class WeatherServiceTest extends TestCase
{

    public function test_it_can_fetch_weather_data()
    {
        // Mock the HTTP request
        Http::fake([
            '*' => Http::response([
                'weather' => [
                    ['description' => 'clear sky']
                ],
                'main' => [
                    'temp' => 25,
                    'humidity' => 50
                ]
            ], 200)
        ]);

        $weatherService = new WeatherService();
        $weather = $weatherService->getWeather('London');

        $this->assertArrayHasKey('weather', $weather);
        $this->assertEquals(25, $weather['main']['temp']);
    }

    public function test_it_throws_exception_when_request_fails()
    {
        // Mock the failed request
        Http::fake([
            '*' => Http::response(null, 500)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unable to fetch weather data');

        $weatherService = new WeatherService();
        $weatherService->getWeather('London');
    }

    public function test_it_can_fetch_weather_data_via_lat_lon()
    {
        // Mock the HTTP request
        Http::fake([
            '*' => Http::response([
                'weather' => [
                    ['description' => 'clear sky']
                ],
                'main' => [
                    'temp' => 25,
                    'humidity' => 50
                ]
            ], 200)
        ]);

        $weatherService = new WeatherService();
        $weather = $weatherService->getWeatherByLatLong('-0.1257','51.5085');

        $this->assertArrayHasKey('weather', $weather);
        $this->assertEquals(25, $weather['main']['temp']);
    }

    public function test_it_throws_exception_when_request_fails_via_lat_lon()
    {
        // Mock the failed request
        Http::fake([
            '*' => Http::response(null, 500)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unable to fetch weather data');

        $weatherService = new WeatherService();
        $weatherService->getWeatherByLatLong('-0.1257','51.5085');
    }
}
