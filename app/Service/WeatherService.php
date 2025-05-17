<?php

namespace App\Service;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{

    public function getCurrentWeather(string $city, string $lang = 'en')
    {
        $key = 'weather_' . strtolower($city) . '_' . strtolower($lang);
        return Cache::remember($key, 300, function () use ($city, $lang) {
            $keyApi = config('services.weatherapi.key');
            $response = Http::get('http://api.weatherapi.com/v1/current.json', [
                'key' => $keyApi,
                'q' => $city,
                'lang' => $lang,

            ]);
            $body = $response->json();
            return (object) [
                'temperature' => $body['current']['temp_c'],
                'condition' => $body['current']['condition']['text'],
                'wind' => $body['current']['wind_kph'],
                'humidity' => $body['current']['humidity'],
                'localTime' => $body['location']['localtime'],
            ];
        });
    }
}