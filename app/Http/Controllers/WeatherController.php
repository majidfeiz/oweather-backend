<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Fetch weather data for the given location.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeather(Request $request)
    {
        $location = $request->query('location', 'London');
//        $lat = $request->query('lat', 'London');
//        $lon = $request->query('lon', 'London');

        try {
            $weather = $this->weatherService->getWeather($location);
//            $weather = $this->weatherService->getWeatherByLatLong($lat,$lon);
            return response()->json([
                'success' => true,
                'data' => $weather,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get the weather directly by latitude and longitude (if no city is needed).
     */
    public function getWeatherByLatLon(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $lat = $request->input('lat');
        $lon = $request->input('lon');

        try {
            // Get weather using latitude and longitude
            $weather = $this->weatherService->getWeatherByLatLong($lat, $lon);

            return response()->json([
                'success' => true,
                'data' => $weather,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
