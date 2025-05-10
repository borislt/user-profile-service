<?php

declare(strict_types=1);

namespace App\Tests\Presentation\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetUserProfileControllerTest extends WebTestCase
{
    public function testGetUserProfile(): void
    {
        $client = static::createClient();
        $client->request('GET', '/v1/profile/018f48fa-9f43-7d31-b97b-82c61d2429b1');

        $this->assertResponseIsSuccessful();
        $expected = [
            'user_profile' => [
                'id' => '018f48fa-9f43-7d31-b97b-82c61d2429b1',
                'email' => 'test@test.com',
                'name' => 'John Foo',
                'avatar_url' => 'https://i.pravatar.cc/300',
                'unknown' => 'alien',
            ],
        ];

        $actual = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($expected, $actual);
    }
}
