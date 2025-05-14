<?php
declare(strict_types=1);

namespace App\Application\UserProfile;

use Ramsey\Uuid\UuidInterface;

interface UserDataProviderInterface
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function getUserData(UuidInterface $userId): array;
}
