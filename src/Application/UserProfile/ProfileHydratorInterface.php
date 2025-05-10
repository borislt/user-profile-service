<?php

declare(strict_types=1);

namespace App\Application\UserProfile;

use App\Domain\User\UserProfile;
use Ramsey\Uuid\UuidInterface;

interface ProfileHydratorInterface
{
    /**
     * @param class-string<UserProfile> $type
     * @param UuidInterface $userId
     * @param array<string, string> $userData
     * @return UserProfile
     */
    public function hydrate(string $type, UuidInterface $userId, array $userData): UserProfile;
}