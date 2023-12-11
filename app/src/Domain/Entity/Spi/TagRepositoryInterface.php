<?php

namespace App\Domain\Entity\Spi;
use App\Domain\Entity\Tag;

interface TagRepositoryInterface
{
    public function findByUuid(string $uuid): ?Tag;

    public function save(Tag $tag): void;

    public function getTagsStatistic(string $tagType, \DateTime $startDate, \DateTime $endDate): array;
}