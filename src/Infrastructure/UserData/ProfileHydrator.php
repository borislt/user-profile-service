<?php

declare(strict_types=1);

namespace App\Infrastructure\UserData;

use App\Application\UserProfile\ProfileHydratorInterface;
use App\Domain\User\UserProfile;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class ProfileHydrator implements ProfileHydratorInterface
{
    public function __construct(private DenormalizerInterface $denormalizer)
    {
    }

    /**
     * @param class-string<UserProfile> $type
     * @param UuidInterface $userId
     * @param array<string, string> $userData
     * @return UserProfile
     */
    public function hydrate(string $type, UuidInterface $userId, array $userData): UserProfile
    {
        return $this->denormalizer->denormalize($userData, UserProfile::class, null, [
            AbstractNormalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS => [
                UserProfile::class => ['id' => $userId],
            ],
        ]);
    }
}