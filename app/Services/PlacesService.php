<?php

namespace App\Services;

use GuzzleHttp\Client;

class PlacesService
{
    private string $apiKey;
    private Client $client;
    private string $url = 'https://api.foursquare.com/v3/autocomplete';
    private array $params = [
        'types' => 'geo',
        'bias' => 'geo',
        'categories' => '16063',
        'limit' => 10,
    ];

    public function __construct()
    {
        $this->apiKey = env('FOURSQUARE_API_KEY');
        $this->client = new Client([
            'verify' => false,
        ]);
    }

    public function search(?string $search)
    {
        if (!$search) {
            return [
                'results' => [],
            ];
        }

        $this->params['query'] = $search;

        return $this->build()->run();
    }

    private function run()
    {
        $response = $this->client->get($this->url, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    private function build()
    {
        $this->url = $this->url.'?'.http_build_query($this->params);

        return $this;
    }
}
