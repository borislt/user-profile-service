<?php
declare(strict_types=1);

namespace App\Presentation\Controller\v1;

use App\Application\UserProfile\GetUserProfileUseCase;
use App\Application\UserProfile\GetUserProfileRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/profile/{id}',
    name: 'v1_get_user_profile',
    requirements: ['id' => Requirement::UUID_V7],
    methods: ['GET'],
)]
class GetUserProfileController extends AbstractController
{
    public function __invoke(string $id, GetUserProfileUseCase $getUserProfile): JsonResponse
    {
        return $this->json($getUserProfile(
            new GetUserProfileRequest(Uuid::fromString($id))
        ));
    }
}