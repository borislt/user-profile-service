<?php

declare(strict_types=1);

namespace App\Infrastructure\UserData\Api;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class HttpClientFactory
{
    /**
     * @param array<string, array<string, string>> $sourceStubs
     */
    public function __construct(
        private bool $mockApi,
        private array $sourceStubs,
    ) {}

    public function create(string $source): HttpClientInterface
    {
        if ($this->mockApi) {
            return new MockHttpClient(
                new JsonMockResponse($this->sourceStubs[$source]),
            );
        }

        return HttpClient::create();
    }
}
