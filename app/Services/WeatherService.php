<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherService
{
    private string $apiKey;
    private Client $client;
    private string $url = 'api.openweathermap.org/data/2.5/forecast';
    private array $params = [];

    public function __construct()
    {
        $this->apiKey = env('OPEN_WEATHER_API_KEY');
        $this->client = new Client([
            'verify' => false,
        ]);
    }

    public function weather($lat, $long)
    {
        $this->params = [
            'lat' => $lat,
            'lon' => $long,
            'units' => 'metric',
            'appid' => $this->apiKey,
        ];

        return $this->run();
    }

    private function run()
    {
        $completeUrl = $this->url.'?'.http_build_query($this->params);

        $response = $this->client->get($completeUrl, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
