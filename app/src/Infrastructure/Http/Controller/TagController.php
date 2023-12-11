<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Exception\TagNotFoundException;
use App\Application\TagService;
use App\Infrastructure\Http\Dto\CreateTagDto;
use App\Infrastructure\Http\Dto\GetTagStats;
use App\Infrastructure\Http\Dto\UpdateTagDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class TagController extends AbstractController
{
    public function __construct(
        private readonly TagService $tagService
    ) {
    }

    #[Route('/api/tag', methods: 'POST')]
    public function create(
        #[MapRequestPayload] CreateTagDto $dto
    ): JsonResponse {
        $tag = $this->tagService->createTag($dto);
        return new JsonResponse(['uuid' => $tag->getUuid()]);
    }

    #[Route('/api/tag', methods: 'PATCH')]
    public function update(
        #[MapRequestPayload] UpdateTagDto $dto
    ): JsonResponse {
        try {
            $this->tagService->updateTag($dto);
        } catch (TagNotFoundException) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Тег не найден');
        }

        return new JsonResponse(['status' => 'OK']);
    }


    #[Route('/api/tag-stats', methods: 'GET')]
    public function getStats(
        #[MapQueryString] GetTagStats $dto
    ): JsonResponse {
        $result = $this->tagService->getTagStats($dto->getStartDate(), $dto->getEndDate(), $dto->getType());
        return new JsonResponse($result);
    }
}