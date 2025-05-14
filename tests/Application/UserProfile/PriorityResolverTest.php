<?php

declare(strict_types=1);

namespace App\Tests\Application\UserProfile;

use App\Application\UserProfile\PriorityResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PriorityResolverTest extends TestCase
{
    /**
     * @param array<string, array<string, int>> $priority
     * @param array<string, mixed> $expected
     */
    #[DataProvider('priorityProvider')]
    public function testMergeWithVariousPriorities(array $priority, array $expected): void
    {
        $userData = [
            'source1' => [
                'email' => 'test@test.com',
                'name' => 'Bar Dor',
            ],
            'source2' => [
                'name' => 'John Foo',
            ],
            'source3' => [
                'name' => 'John Bar',
                'avatar_url' => 'https://i.pravatar.cc/300',
            ],
            'source4' => [
                'unknown' => 'alien',
            ],
        ];

        $resolver = new PriorityResolver($priority);
        $actual = $resolver->merge($userData);

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array{mixed, mixed}>
     */
    public static function priorityProvider(): array
    {
        return [
            'original_priorities' => [
                [
                    'source1' => ['email' => 0, 'name' => 2],
                    'source2' => ['name' => 0],
                    'source3' => ['name' => 1, 'avatar_url' => 0],
                    'source4' => ['unknown' => 0],
                ],
                [
                    'email' => 'test@test.com',
                    'name' => 'John Foo',
                    'avatar_url' => 'https://i.pravatar.cc/300',
                    'unknown' => 'alien',
                ],
            ],
            'source1_name_has_priority' => [
                [
                    'source1' => ['email' => 0, 'name' => 0],
                    'source2' => ['name' => 2],
                    'source3' => ['name' => 1, 'avatar_url' => 0],
                    'source4' => ['unknown' => 0],
                ],
                [
                    'email' => 'test@test.com',
                    'name' => 'Bar Dor',
                    'avatar_url' => 'https://i.pravatar.cc/300',
                    'unknown' => 'alien',
                ],
            ],
            'source3_name_has_priority' => [
                [
                    'source1' => ['email' => 1, 'name' => 2],
                    'source2' => ['name' => 3],
                    'source3' => ['name' => 0, 'avatar_url' => 0],
                    'source4' => ['unknown' => 0],
                ],
                [
                    'email' => 'test@test.com',
                    'name' => 'John Bar',
                    'avatar_url' => 'https://i.pravatar.cc/300',
                    'unknown' => 'alien',
                ],
            ],
            'source4_name_missing_priority' => [
                [
                    'source1' => ['email' => 0],
                    'source2' => [],
                    'source3' => ['avatar_url' => 0],
                    'source4' => ['unknown' => 0],
                ],
                [
                    'email' => 'test@test.com',
                    'avatar_url' => 'https://i.pravatar.cc/300',
                    'unknown' => 'alien',
                ],
            ],
        ];
    }
}
