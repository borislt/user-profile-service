<?php
declare(strict_types=1);

namespace App\Application\UserProfile;

use App\Domain\User\UserProfile;

readonly class GetUserProfileUseCase
{
    public function __construct(
        private UserDataProviderInterface $userDataProvider,
        private PriorityResolver $priorityResolver,
        private ProfileHydratorInterface $hydrator,
    ) {}

    public function __invoke(GetUserProfileRequest $request): GetUserProfileResponse
    {
        $userData = $this->userDataProvider->getUserData($request->userId);

        $aggregatedUserData = $this->priorityResolver->merge($userData);

        $userProfile = $this->hydrator->hydrate(UserProfile::class, $request->userId, $aggregatedUserData);

        return new GetUserProfileResponse($userProfile);
    }
}