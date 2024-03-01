<?php

namespace App\Controller;

use App\Domain\ConversationService;
use App\Dto\Core\CollectionDto;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConversationController extends BaseController
{
    #[Route('/conversations', name: 'app_conversation')]
    public function getMyConversations(ConversationService $service, Request $request): Response
    {
        $dto = new CollectionDto();

        try {
            $conversationsDto = $service->getConversations();
            $dto->data = $conversationsDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        $response = new Response($this->serialize($dto));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}