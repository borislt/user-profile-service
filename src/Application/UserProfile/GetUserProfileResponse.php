<?php
declare(strict_types=1);

namespace App\Application\UserProfile;

use App\Domain\User\UserProfile;

readonly class GetUserProfileResponse
{
    public function __construct(
        public UserProfile $userProfile,
    ) {}
}