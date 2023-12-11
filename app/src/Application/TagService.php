<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Exception\TagNotFoundException;
use App\Domain\Entity\Spi\TagRepositoryInterface;
use App\Domain\Entity\Tag;
use App\Domain\Entity\ValueObject\TagType;
use App\Infrastructure\Http\Dto\CreateTagDto;
use App\Infrastructure\Http\Dto\UpdateTagDto;

class TagService
{
    public function __construct(
        private readonly TagRepositoryInterface $tagRepository
    ) {
    }

    public function createTag(CreateTagDto $dto): Tag
    {
        $tag = new Tag(
            $dto->getName(),
            $dto->getColor(),
            new TagType($dto->getType()),
            $dto->getScore()
        );
        $this->tagRepository->save($tag);

        return $tag;
    }

    public function updateTag(UpdateTagDto $dto): void
    {
        $tag = $this->tagRepository->findByUuid($dto->getUuid());
        if ($tag === null) {
            throw new TagNotFoundException();
        }

        $tag->setColor($dto->getColor());
        $this->tagRepository->save($tag);
    }

    public function getTagStats(\DateTime $startDate, \DateTime $endDate, string $type): array
    {
        return $this->tagRepository->getTagsStatistic($type, $startDate, $endDate);
    }
}