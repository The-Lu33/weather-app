<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class WeatherService
{

    public function getCurrentWeather(string $city)
    {
        $key = config('services.weatherapi.key');
        $response = Http::get('http://api.weatherapi.com/v1/current.json', [
            'key' => $key,
            'q' => $city,
        ]);

        $body = $response->json();
        return (object) [
            'temperature' => $body['current']['temp_c'],
            'condition' => $body['current']['condition']['text'],
            'wind' => $body['current']['wind_kph'],
            'humidity' => $body['current']['humidity'],
            'localTime' => $body['location']['localtime'],
        ];
    }
}