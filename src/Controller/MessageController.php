<?php

namespace App\Controller;

use App\Domain\MessageService;
use App\Dto\Core\CollectionDto;
use App\Dto\Core\EntityDto;
use App\Dto\PostMessage;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends BaseController
{
    #[Route('/conversations/{conversationId}/messages', name: 'app_conversation_messages', methods: ['GET'])]
    public function getConversationMessages(
        MessageService $service,
        Request $request,
        string $conversationId
    ): Response
    {
        $dto = new CollectionDto();

        try {
            $messagesDto = $service->getMessages($conversationId);
            $dto->data = $messagesDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        $response = new Response($this->serialize($dto));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/conversations/{conversationId}/messages', name: 'app_conversation_messages_new', methods: ['POST'])]
    public function postNewConversationMessages(
        MessageService $service,
        Request $request,
        string $conversationId
    ): Response
    {
        $dto = new EntityDto();

        try {
            $data = $this->deserialize(PostMessage::class, $request->getContent());

            $messageDto = $service->createNewMessage($data, $conversationId);
            $dto->data = $messageDto;
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