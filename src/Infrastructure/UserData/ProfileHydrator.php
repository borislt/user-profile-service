<?php

declare(strict_types=1);

namespace App\Infrastructure\UserData;

use App\Application\UserProfile\ProfileHydratorInterface;
use App\Domain\User\UserProfile;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

readonly class ProfileHydrator implements ProfileHydratorInterface
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private LoggerInterface $logger,
    ) {}

    /**
     * @param array<string, mixed> $userData
     */
    public function hydrate(UserProfile $userProfile, array $userData): UserProfile
    {
        try {
            $this->denormalizer->denormalize($userData, UserProfile::class, null, [
                AbstractNormalizer::OBJECT_TO_POPULATE => $userProfile,
            ]);
        } catch (ExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $userProfile;
    }
}