<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData;

use Symfony\Component\Validator\Constraints as Assert;

class UserDataDto
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        private $name = '',

        #[Assert\Type('string')]
        #[Assert\NotNull]
        #[Assert\Length(max: 255)]
        #[Assert\Email]
        private $email = '',

        #[Assert\Type('string')]
        #[Assert\NotNull]
        #[Assert\Length(max: 2048)]
        #[Assert\Url]
        private $avatarUrl = '',

        #[Assert\Type('string')]
        #[Assert\NotNull]
        #[Assert\Length(max: 500)]
        private $unknown = '',
    ) {}
}