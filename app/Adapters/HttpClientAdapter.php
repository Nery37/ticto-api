<?php

declare(strict_types=1);

namespace App\Adapters;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HttpClientAdapter
{
    protected Client $client;
    protected array $config;

    public function __construct(array $config)
    {
        $this->client = new Client($config);
        $this->config = $config;
    }

    public function get(string $endpoint, array $options = []): ResponseAdapter
    {
        return $this->request('GET', $endpoint, $options);
    }

    public function post(string $endpoint, array $options = []): ResponseAdapter
    {
        return $this->request('POST', $endpoint, $options);
    }

    public function put(string $endpoint, array $options = []): ResponseAdapter
    {
        return $this->request('PUT', $endpoint, $options);
    }

    public function delete(string $endpoint, array $options = []): ResponseAdapter
    {
        return $this->request('DELETE', $endpoint, $options);
    }

    private function request(string $method, string $endpoint, array $options): ResponseAdapter
    {
        $requestData = ('GET' === $method) ? ['query' => $options] : ['json' => $options];
        $requestData['headers'] = $this->config['headers'] ?? [];
        $response = $this->client->request($method, $endpoint, $requestData);
        return $this->response($endpoint, $options, $response);
    }

    private function response(string $endpoint, array $options, ResponseInterface $response): ResponseAdapter
    {
        $result = new \stdClass();
        $result->statusCode = $response->getStatusCode();
        $result->rawData = $response->getBody()->getContents();

        (new LogRequestAdapter())->logsRequests(
            $endpoint,
            $result->rawData,
            $result->statusCode,
            $options
        );

        return new ResponseAdapter($result);
    }
}
