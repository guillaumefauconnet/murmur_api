<?php

namespace App\Controller;

use App\Domain\MessageService;
use App\Dto\Core\CollectionDto;
use App\Dto\Core\EntityDto;
use App\Dto\PostMessage;
use App\Repository\MessageRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends BaseController
{
    #[Route('/conversations/{conversationId}/messages', name: 'get_conversation_messages', methods: ['GET'])]
    public function getConversationMessages(
        MessageService $service,
        Request $request,
        string $conversationId
    ): JsonResponse
    {
        $status = 200;
        $dto = new CollectionDto();

        try {
            $messagesDto = $service->getMessages($conversationId);
            $dto->data = $messagesDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations/{conversationId}/messages', name: 'new_conversation_message', methods: ['POST'])]
    public function postNewConversationMessage(
        MessageService $service,
        Request $request,
        string $conversationId
    ): JsonResponse
    {
        $status = 201;
        $dto = new EntityDto();

        try {
            $data = $this->deserialize(PostMessage::class, $request->getContent());

            $messageDto = $service->createNewMessage($data, $conversationId);
            $dto->data = $messageDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations/{conversationId}/messages/{messageId}', name: 'delete_conversation_message', methods: ['DELETE'])]
    public function deleteConversationMessage(
        MessageService $service,
        Request $request,
        string $conversationId,
        string $messageId,
        MessageRepository $messageRepository
    ): Response
    {
        //TODO TMP FOR TEST. MAKE THIS CLEANER
        $status = 204;
        $messageRepository->delete($messageId);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    //TODO ADD DATES TO DTO MESSAGES
    //TODO OR NOT TODO update message
    //TODO OR NOT TODO delete message (soft delete)
    //TODO OR NOT TODO get message
}