<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbAPIService {

    private const OMDB_ENDPOINT = "https://omdbapi.com";

    private HttpClientInterface $httpClient;
    private string $apiKey;

    public function __construct(HttpClientInterface $http, string $apiKey)
    {
        $this->httpClient = $http;
        $this->apiKey = $apiKey;
    }

    public function fetchMovieByTitle(string $title) : ?array 
    {
        $data = [
            'apikey' => $this->apiKey,
            't' => $title 
        ];
        $data = ['query' => $data];

        $result = $this->httpClient->request('GET', self::OMDB_ENDPOINT, $data)->toArray();

        if($result['Response'] == 'False') {
            return null;
        }

        echo "result";
        var_dump($result);

        return $result;
    }
}
