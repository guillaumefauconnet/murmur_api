<?php

namespace App\Controller;

use App\Domain\ConversationService;
use App\Dto\Core\CollectionDto;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends BaseController
{
    #[Route('/conversations/{conversationId}/messages', name: 'app_conversation_messages')]
    public function getConversationMessages(MessageService $service, Request $request): Response
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