<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class WeatherApiTest extends TestCase
{
    public function test_it_can_fetch_weather_data_via_location_api()
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

        $response = $this->getJson('/api/weather?location=London');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'weather',
                    'main' => ['temp', 'humidity'],
                ]
            ]);
    }

    public function test_it_returns_error_when_servic_location_fails()
    {
        // Mock the failed request
        Http::fake([
            '*' => Http::response(null, 500)
        ]);

        $response = $this->getJson('/api/weather?location=london');

        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'message' => 'Unable to fetch weather data',
            ]);
    }

    public function test_it_can_fetch_weather_data_via_lat_lon_api()
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

        $response = $this->getJson('/api/weather-latlon?lat=-0.1257&lon=51.5085');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'weather',
                    'main' => ['temp', 'humidity'],
                ]
            ]);
    }

}
