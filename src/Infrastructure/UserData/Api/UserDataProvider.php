<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData\Api;

use App\Application\UserProfile\UserDataProviderInterface;
use App\Infrastructure\UserData\UserDataSanitizer;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class UserDataProvider implements UserDataProviderInterface
{
    /**
     * @param array<string, string> $sourceUrls
     */
    public function __construct(
        private array $sourceUrls,
        private HttpClientFactory $httpClientFactory,
        private UserDataSanitizer $sanitizer,
        private LoggerInterface $logger,
    ) {}

    public function getUserData(UuidInterface $userId): array
    {
        $responses = [];

        foreach ($this->sourceUrls as $source => $url) {
            $client = $this->httpClientFactory->create($source);
            try {
                $responses[$source] = $client->request(
                    Request::METHOD_GET,
                    $url,
                    ['query' => ['userId' => $userId]],
                );
            } catch (TransportExceptionInterface $exception) {
                $this->logger->error($exception->getMessage());
                continue;
            }
        }

        $results = [];

        foreach ($responses as $source => $response) {
            try {
                $results[$source] = $response->toArray();
            } catch (ExceptionInterface $exception) {
                $this->logger->error($exception->getMessage());
                continue;
            }
        }

        return $this->sanitizer->sanitize($results);
    }
}
