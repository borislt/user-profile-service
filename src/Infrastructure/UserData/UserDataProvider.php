<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData;

use App\Application\UserProfile\UserDataProviderInterface;
use App\Infrastructure\UserData\Api\SourceClientInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

readonly class UserDataProvider implements UserDataProviderInterface
{
    public function __construct(
        /** @var SourceClientInterface[] */
        private iterable $apiClients,
        private UserDataSanitizer $sanitizer,
        private LoggerInterface $logger,
    ) {}

    /**
     * @return array<string, array<string, string>>
     */
    public function getUserData(UuidInterface $userId): array
    {
        $responses = [];

        // https://symfony.com/doc/6.4/http_client.html#concurrent-requests
        foreach ($this->apiClients as $apiClient) {
            $responses[$apiClient->getSource()->value] = $apiClient->fetchUserData($userId);
        }

        $results = [];

        foreach ($responses as $source => $response) {
            try {
                $results[$source] = $response->toArray();
            } catch (ExceptionInterface $exception) {
                $this->logger->error($exception);
            }
        }

        return $this->sanitizer->sanitize($results);
    }
}