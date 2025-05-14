<?php

declare(strict_types=1);

namespace App\Application\UserProfile;

use App\Domain\User\UserProfile;

interface ProfileHydratorInterface
{
    /**
     * @param array<string, mixed> $userData
     */
    public function hydrate(UserProfile $userProfile, array $userData): UserProfile;
}
