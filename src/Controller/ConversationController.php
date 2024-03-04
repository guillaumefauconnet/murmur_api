<?php

namespace App\Controller;

use App\Domain\ConversationService;
use App\Dto\Core\CollectionDto;
use App\Dto\Core\EntityDto;
use App\Dto\PostConversation;
use App\Dto\PostUser;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConversationController extends BaseController
{
    #[Route('/conversations', name: 'app_conversation', methods: ['GET'])]
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

    #[Route('/conversations', name: 'app_conversation_new', methods: ['POST'])]
    public function postNewConversations(ConversationService $service, Request $request): Response
    {
        $dto = new EntityDto();

        try {
            $data = $this->deserialize(PostConversation::class, $request->getContent());

            $conversationDto = $service->createNewConversation($data);

            $dto->data = $conversationDto;
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