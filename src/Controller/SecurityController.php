<?php

namespace App\Controller;

use App\Domain\UserService;
use App\Dto\PostUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends BaseController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        UserService $service,
        Request $request
    ): JsonResponse
    {
        $data = $this->deserialize(PostUser::class, $request->getContent());
        $responseDto = $service->registerUser($data);

        return new JsonResponse($this->serialize($responseDto), 200, [], true);
    }
}