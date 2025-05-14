<?php
declare(strict_types=1);

namespace App\Infrastructure\UserData;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

readonly class UserDataSanitizer
{
    public function __construct(
        private ValidatorInterface $validator,
        private DenormalizerInterface $denormalizer,
        private NameConverterInterface $converter,
        private LoggerInterface $logger,
    ) {}

    /**
     * @param array<string, array<string, mixed>> $userData
     * @return array<string, array<string, mixed>>
     */
    public function sanitize(array $userData): array
    {
        $result = [];

        foreach ($userData as $source => $data) {
            try {
                $userDataDto = $this->denormalizer->denormalize($data, UserDataDto::class);
                $violations = $this->validator->validate($userDataDto);

                foreach ($violations as $violation) {
                    unset($data[$this->converter->normalize($violation->getPropertyPath())]);
                    $this->logger->error($violation->getMessage(), [
                        'source' => $source,
                        'property' => $violation->getPropertyPath(),
                        'value' => $violation->getInvalidValue(),
                    ]);
                }

                $result[$source] = $data;
            } catch (ExceptionInterface $exception) {
                $this->logger->error($exception->getMessage());
            }
        }

        return $result;
    }
}