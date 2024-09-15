<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class WeatherService
{
    protected $apiUrl;
    protected $apiKey;
    public function __construct()
    {
        // These could be configured in your .env file
        $this->apiUrl = config('services.weather.api_url');
        $this->apiKey = config('services.weather.api_key');
    }

    /**
     * Fetch the weather data from the external weather API.
     *
     * @param string $location
     * @return array
     * @throws RequestException
     */
    public function getWeather(string $location): array
    {
        try {
            $response = Http::get($this->apiUrl, [
                'q' => $location,
                'appid' => $this->apiKey,
                'units' => 'metric' // For Celsius
            ]);

            // Throw exception if the request fails
            $response->throw();

            return $response->json();
        } catch (RequestException $e) {
            throw new \Exception('Unable to fetch weather data');
        }
    }

    /**
     * Get weather data by latitude and longitude.
     */
    public function getWeatherByLatLong($lat, $lon)
    {
        try {
            $response = Http::get($this->apiUrl, [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
                'units' => 'metric' // For Celsius
            ]);
            // Throw exception if the request fails
            $response->throw();

            return $response->json();
        }catch (RequestException $e)
        {
            throw new \Exception('Unable to fetch weather data');

        }

    }
}
