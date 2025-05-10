<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData\Api;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class Source3Client implements SourceClientInterface
{
    public function __construct(private string $domain) {
    }

    public function getSource(): Source
    {
        return Source::Source3;
    }

    public function fetchUserData(UuidInterface $userId): ResponseInterface
    {
        $client = new MockHttpClient([
            new MockResponse(json_encode([
                'name' => 'John Bar',
                'avatar_url' => 'https://i.pravatar.cc/300',
            ])),
        ]);

        return $client->request(
            Request::METHOD_GET,
            sprintf('%s/user/%s', $this->domain, $userId),
        );
    }
}