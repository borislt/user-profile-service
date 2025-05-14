<?php
declare(strict_types=1);

namespace App\Application\UserProfile;

readonly class PriorityResolver
{
    /**
     * @param array<string, array<string, int>> $priority
     */
    public function __construct(private array $priority)
    {
    }

    /**
     * @param  array<string, array<string, mixed>> $userData
     * @return array<string, mixed>
     */
    public function merge(array $userData): array
    {
        $result = [];

        foreach ($userData as $source => $fields) {
            foreach ($fields as $field => $value) {
                if (!isset($this->priority[$source][$field])) {
                    continue;
                }

                $fieldPriority = $this->priority[$source][$field];

                if (!isset($result[$field])) {
                    $result[$field] = ['value' => $value, 'priority' => $fieldPriority];
                } elseif ($fieldPriority < $result[$field]['priority']) {
                    $result[$field] = ['value' => $value, 'priority' => $fieldPriority];
                }
            }
        }

        return array_map(fn ($data) => $data['value'], $result);
    }
}