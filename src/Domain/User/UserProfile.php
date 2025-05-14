<?php
declare(strict_types=1);

namespace App\Domain\User;

use Ramsey\Uuid\UuidInterface;

class UserProfile
{
    public function __construct(
        public readonly UuidInterface $id,
        public string $email = '',
        public string $name = '',
        public string $avatarUrl = '',
        public string $unknown = '',
    ) {}
}