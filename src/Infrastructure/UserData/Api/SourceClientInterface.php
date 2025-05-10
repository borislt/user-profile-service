<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData\Api;

use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface SourceClientInterface
{
    public function getSource(): Source;
    public function fetchUserData(UuidInterface $userId): ResponseInterface;
}