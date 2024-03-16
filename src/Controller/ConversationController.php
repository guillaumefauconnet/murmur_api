<?php

namespace App\Controller;

use App\Domain\ConversationService;
use App\Dto\Core\CollectionDto;
use App\Dto\Core\EntityDto;
use App\Dto\PatchConversation;
use App\Dto\PostConversation;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ConversationController extends BaseController
{
    #[Route('/conversations', name: 'get_conversations', methods: ['GET'])]
    public function getMyConversations(
        ConversationService $service,
        Request $request
    ): JsonResponse
    {
        $status = 200;
        $dto = new CollectionDto();

        try {
            $conversationsDto = $service->getMyConversations();
            $dto->data = $conversationsDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations/{conversationId}', name: 'get_conversation', methods: ['GET'])]
    public function getConversation(
        ConversationService $service,
        string $conversationId,
        Request $request
    ): JsonResponse
    {
        $status = 200;
        $dto = new EntityDto();

        try {
            $conversationDto = $service->getOneConversation($conversationId);
            $dto->data = $conversationDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations', name: 'new_conversation', methods: ['POST'])]
    public function postNewConversation(
        ConversationService $service,
        Request $request
    ): JsonResponse
    {
        $status = 201;
        $dto = new EntityDto();

        try {
            $data = $this->deserialize(PostConversation::class, $request->getContent());

            $conversationDto = $service->createNewConversation($data);

            $dto->data = $conversationDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations/{conversationId}', name: 'update_conversation', methods: ['PATCH'])]
    public function patchConversation(
        ConversationService $service,
        Request $request,
        string $conversationId
    ): JsonResponse
    {
        $status = 201;
        $dto = new EntityDto();

        try {
            $data = $this->deserialize(PatchConversation::class, $request->getContent());

            $conversationDto = $service->updateConversation($data, $conversationId);

            $dto->data = $conversationDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations/{conversationId}/users/{userId}', name: 'add_user_conversation', methods: ['POST'])]
    public function addUserToConversation(
        ConversationService $service,
        Request $request,
        string $conversationId,
        string $userId
    ): JsonResponse
    {
        $status = 201;
        $dto = new EntityDto();

        try {
            $conversationDto = $service->addUserToConversation($conversationId, $userId);

            $dto->data = $conversationDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    #[Route('/conversations/{conversationId}/users/{userId}', name: 'remove_user_conversation', methods: ['DELETE'])]
    public function removeUserToConversation(
        ConversationService $service,
        Request $request,
        string $conversationId,
        string $userId
    ): JsonResponse
    {
        $status = 201;
        $dto = new EntityDto();

        try {
            $conversationDto = $service->removeUserToConversation($conversationId, $userId);

            $dto->data = $conversationDto;
            $dto->state = 'success';
        } catch (Exception $e) {
            $status = 500;
            $dto->state = 'error';
            $dto->message = $e->getMessage();
        }

        return new JsonResponse($this->serialize($dto), $status, [], true);
    }

    //TODO OR NOT TODO delete conversation (soft delete)
}