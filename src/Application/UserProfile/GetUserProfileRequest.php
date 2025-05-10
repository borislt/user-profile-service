<?php
declare(strict_types=1);

namespace App\Application\UserProfile;

use Ramsey\Uuid\UuidInterface;

readonly class GetUserProfileRequest
{
    public function __construct(
        public UuidInterface $userId,
    ) {}
}