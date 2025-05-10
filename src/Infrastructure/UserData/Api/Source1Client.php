<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData\Api;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class Source1Client implements SourceClientInterface
{
    public function __construct(private string $domain) {
    }

    public function getSource(): Source
    {
        return Source::Source1;
    }

    public function fetchUserData(UuidInterface $userId): ResponseInterface
    {
        $client = new MockHttpClient([
            new MockResponse(json_encode([
                'email' => 'test@test.com',
                'name' => 'Bar Dor',
            ])),
        ]);

        return $client->request(
            Request::METHOD_GET,
            sprintf('%s/user/%s', $this->domain, $userId),
        );
    }
}