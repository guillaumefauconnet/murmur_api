<?php

namespace App\Controller;

use App\Domain\UserService;
use App\Dto\PostUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends BaseController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        UserService $service,
        Request $request
    ): Response
    {
        $data = $this->deserialize(PostUser::class, $request->getContent());
        $responseDto = $service->registerUser($data);

        $response = new Response($this->serialize($responseDto));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}