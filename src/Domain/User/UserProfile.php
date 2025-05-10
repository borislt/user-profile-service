<?php
declare(strict_types=1);

namespace App\Domain\User;

use Ramsey\Uuid\UuidInterface;

readonly class UserProfile
{
        public function __construct(
        public UuidInterface $id,
        public string $email = '',
        public string $name = '',
        public string $avatarUrl = '',
        public string $unknown = '',
    ) {}
}