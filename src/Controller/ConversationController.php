<?php

namespace App\Controller;

use App\Domain\ConversationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConversationController extends BaseController
{
    #[Route('/conversations', name: 'app_conversation')]
    public function getMyConversations(ConversationService $service, Request $request): Response
    {
        $responseDto = $service->getConversations();

        $obj = new \stdClass();
        $obj->conversations = $responseDto;

        $response = new Response($this->serialize($obj));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}