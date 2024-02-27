<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController
{
    #[Route('/register', name: 'app_register')]
    public function register(EntityManagerInterface $em): JsonResponse
    {
        $user = new User();
        $user->setMail("test@test.com");
        $user->setPassword("passowrd");
        $user->setGlobalNickName('Test');

        $em->persist($user);
        $em->flush();
    }

}